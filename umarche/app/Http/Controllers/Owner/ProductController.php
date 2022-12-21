<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\PrimaryCategory;
use App\Models\Owner;
use App\Models\Shop;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners'); 

        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameter('product');
            if(!is_null($id)){
            $productsOwnerId = Product::findOrFail($id)->shop->owner->id;
              $productId = (int)$productsOwnerId;
              if($productId !== Auth::id()){
              abort(404);
              }
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     * ログインしている
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Auth::id()を引数とすることでログインしているowner_idをとれる。shopを経由してproductへリレーション
        //することで、ログインしているownerのproductを取得できる。

        //$this->viewData['products'] = Owner::findOrFail(Auth::id())->shop->product;
        $this->viewData['ownerInfo'] = Owner::with('shop.product.imageFirst') ->where('id', Auth::id())->get();
        // foreach($ownerInfo as $owner)
        // //dd($owner->shop->product);
        //  foreach($owner->shop->product as $product)
        //  {
        //     dd($product->imageFirst->filename);
        //  }
        return view('owner.products.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //1つのshop,image,categoryは複数のproductをもつのでFKを３つ定義してるのでそれをかく
        //owner_idのAUTHで絞りつつ、それぞれselectする
        $shops = Shop::where('owner_id', Auth::id())->select('id', 'name')->get();
        //orderByで新しい順に並び替え
        $images = Image::where('owner_id', Auth::id())->select('id', 'title', 'filename')->orderBy('updated_at', 'desc')->get();
        //リレーション先のprimaryCategoryからとるのでN+1問題回避,secondaryというのはprimarycategoryモデルのメソッド
        $categories = PrimaryCategory::with('secondary') ->get();
        return view('owner.products.create', compact('shops', 'images', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
