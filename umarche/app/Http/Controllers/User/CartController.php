<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use App\Services\Cart\CartService;
use App\Jobs\SendThanksMail;
use App\Jobs\SendOrderedMail;

class CartController extends Controller
{
    public function index()
    {
        //ログインしてるユーザーの取得
        $user = User::findOrFail(Auth::id());
        //userに紐づくproductsを取得→多対多のリレーション
        $products = $user->products;
        $totalPrice = 0;
        foreach($products as $product){
            //productのquantityをとpriceをかけて合計金額をだしてtotalpriceに＋する→中間テーブルなのでpivotをはさむ
            $totalPrice += $product->price * $product->pivot->quantity;
        }
        //dd($products,$totalPrice);
        return view('user.cart',compact('products','totalPrice'));
    }

    public function add(Request $request)
    {
        //カートに商品があるか確認(product_idがあるかどうか、'user_id', Auth::id())でログインしているユーザーであるかどうか)
        $itemInCart = Cart::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
        //もしカートに商品があれば、数量を追加する。(すでにカートに商品が1あった場合、2つ追加したら3になるようにする)
        if($itemInCart){
        $itemInCart->quantity += $request->quantity;
        $itemInCart->save();
        //なければ商品を新規作成
        } else {
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity
        ]); 
        }
        //dd('test');
        return redirect()->route('user.cart.index');
    }

    public function delete($id)
    {
        //product_idのidとログインしているuser_id検索してきて削除
        Cart::where('product_id', $id) ->where('user_id', Auth::id())->delete();
        return redirect()->route('user.cart.index');
    }

    public function checkout()
    {
        ///カートの中のログインしてるユーザーが設定している商品を取得
        $items = Cart::where('user_id', Auth::id())->get();
        $products = CartService::getItemsInCart($items);
        ///
        $user = User::findOrFail(Auth::id());
        SendThanksMail::dispatch($products, $user);
        //オーナー向けメール(複数送信)
        foreach($products as $product)
        {
          SendOrderedMail::dispatch($product, $user);
        }
            
        dd('メール送信テスト');

        $user = User::findOrFail(Auth::id());
        //userに紐づくproductsを取得→多対多のリレーション
        $products = $user->products;
        //カートに入ってる商品
        $lineItems = [];
        //foreachですべてのカートに入ってる商品を取得しlineitemsという配列へ追加していく
        foreach($products as $product){
            //現在の在庫数の取得
            $quantity ='';
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');
            //もしcart内の在庫($product->pivot->quantity)が現在の在庫数($quantity)より多かったらリダイレクト
            if($product->pivot->quantity > $quantity){
                return redirect()->route('user.cart.index');
            }else{
                //商品情報をstripe側に受け取れる形にして渡す→stripe側で用意してるパラメータを使用
                //cart内の商品が在庫数より少なければ購入できる
                //2022年8月1日のAPI仕様変更
                $lineItem = [
                    'price_data' => [
                    'unit_amount' => $product->price,
                    'currency' => 'JPY',
 
                        'product_data' => [
                        'name' => $product->name,
                        'description' => $product->information,
                        ],
                    ],
                    'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems, $lineItem);
            }
        }
        //dd($lineItems);
        //stripeに渡す前に在庫をへらす
        foreach($products as $product) {
            Stock::create([
            'product_id' => $product->id,
            'type' => \Constant::PRODUCT_LIST['reduce'],
            //カートの中の在庫数をへらす
            'quantity' => $product->pivot->quantity * -1
            ]);
        }
        //dd('test');
        //シークレットキーを取得、envヘルパ関数でとってこれる
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        //支払い方法やカートに入った商品情報、リダイレクト先などを$sessionへ格納
        $session = \Stripe\Checkout\Session::create([
            //支払い方法
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            //1回払
            'mode' => 'payment',
            //支払い成功後のリダイレクト先
            'success_url' => route('user.cart.success'),
            'cancel_url' => route('user.cart.cancel'),
        ]);
        //公開可能キーの取得
        $publicKey = env('STRIPE_PUBLIC_KEY');
        //viewへ2つのキーが入った変数を渡す
        return view('user.checkout',compact('session', 'publicKey'));
    }

    public function success()
    {
        //決済成功時、cartを削除する
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->route('user.items.index');
    }

    public function cancel()
    {
        //user情報取得
        $user = User::findOrFail(Auth::id());
        //stripe処理キャンセル時に在庫をふやす
        foreach($user->products as $product) {
            Stock::create([
            'product_id' => $product->id,
            'type' => \Constant::PRODUCT_LIST['add'],
            //カートの中の在庫数をふやす
            'quantity' => $product->pivot->quantity
            ]);
        }
        //キャンセル後カートへリダイレクト
        return redirect()->route('user.cart.index');
    }
}
