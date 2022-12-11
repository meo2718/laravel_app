<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Shop;

class ShopController extends Controller
{
    //コンストラクタでミドルウェアを設定しownerで認証していた場合実行する
    public function __construct()
    {
        $this->middleware('auth:owners'); 

        $this->middleware(function ($request, $next) {
            //idは文字列になる
            //indexにアクセスするとnullになる
            //dd($request->route()->parameter('shop'));
            //dd(Auth::id());//idは数字になる

            //shopのid取得
            $id = $request->route()->parameter('shop');
            //owner/shops/indexにアクセスした場合nullなので判定
            if(!is_null($id)){
            //shopのidからowner_idを取得する
            $shopsOwnerId = Shop::findOrFail($id)->owner->id;
              //キャスト 文字列→数値に型変換
              $shopId = (int)$shopsOwnerId;
              $ownerId = Auth::id();
              // 同じでなかったら404
              if($shopId !== $ownerId){
              //abortで404画面表示
              abort(404);
              }
            }
            return $next($request);
        });
    }

    public function index()
    {
        //ログインしているオーナーのIDを取得
        $ownerId = Auth::id();
        //１人のownerが複数のshopをもちたいので、owner_idをログインしている$ownerIDでwhereで検索してgetすればよい

        $this->viewData['shops'] = Shop::where('owner_id', $ownerId)->get();
        return view('owner.shops.index', $this->viewData);
    }

    public function edit($id)
    {
        //dd(Shop::findOrFail($id));

    }

    public function update(Request $request, $id)
    {

    }
}
