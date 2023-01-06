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
        //在庫が1以上か、販売中かどうかのチェックする処理

    }

    public function index()
    {
        //Stockの合計をグループ化して数量が1以上 という条件を作る
        //select内でsumを使うため クエリビルダのDB::rawで対応する
        $stocks = DB::table('t_stocks') 
        ->select('product_id', DB::raw('sum(quantity) as quantity')) 
        ->groupBy('product_id') 
        ->having('quantity', '>', 1);
        //$stocks側で条件としたので変数として渡し、 'stock'という名前とし、function($join)でproductテーブルとstockテーブルをくっつける
        //products、shops、stocksをjoin句で紐付けて where句で is_sellingがtrueかの条件指定
        $products = DB::table('products')
        ->joinSub($stocks, 'stock', function($join){
        //さらにproductとshopテーブルをjoinでつなげる
        $join->on('products.id', '=', 'stock.product_id'); })
        ->join('shops', 'products.shop_id', '=', 'shops.id')
        ->join('secondary_categories', 'products.secondary_category_id', '=', 'secondary_categories.id')
        ->join('images as image1', 'products.image1', '=', 'image1.id')
        //shopsとproductsのis_sellingがtrueならgetする
        ->where('shops.is_selling', true)
        ->where('products.is_selling', true)

        ->select('products.id as id', 'products.name as name', 'products.price' ,'products.sort_order as sort_order',
        'products.information', 'secondary_categories.name as category' ,'image1.filename as filename')
        ->get();

        //dd($stocks,$products);

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
