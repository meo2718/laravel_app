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

    }

    public function update(Request $request, $id)
    {

    }
}
