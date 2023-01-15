<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function __construct()
    {
        //ガード設定
        $this->middleware('auth:users'); 
        //is_selling=0の商品のIDをURLに直接いれたら404を返す処理
        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameter('item');
            if(!is_null($id)){
            //availableItemsに$requestではいってきた$idが存在しているかどうかチェック
            $itemId = Product::availableItems()->where('products.id',$id)->exists();
              if(!$itemId){
              abort(404);
              }
            }
            return $next($request);
        });

    }

    public function index(Request $request)
    {
        //商品一覧クエリ、表示順クエリ→product.phpで定義
        //$request->sortでviewとモデルへ渡す
        $products = Product::availableItems()->sortOrder($request->sort)->get();
        return view('user.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        //数量表示、9より大きかったら9まで表示させる
        $quantity = Stock::where('product_id', $product->id)->sum('quantity');
        if($quantity >9 ){
            $quantity = 9;
        }
        return view ('user.show', compact('product','quantity'));
    }
}
