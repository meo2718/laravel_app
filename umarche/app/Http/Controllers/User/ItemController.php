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
        $products = Product::availableItems()->get();
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
