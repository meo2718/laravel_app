<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;

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
        //$ownerId = Auth::id();
        //１人のownerが複数のshopをもちたいので、owner_idをログインしている$ownerIDでwhereで検索してgetすればよい
        $this->viewData['shops'] = Shop::where('owner_id', Auth::id())->get();
        return view('owner.shops.index', $this->viewData);
    }
    /**
     * shop画像アップロード画面遷移+更新
     * @param $request
     * @param $id
     */
    public function edit(Request $request, $id)
    {
        if($request->isMethod('get')){
          $this->viewData['shop'] = Shop::findOrFail($id);
          return view('owner.shops.edit', $this->viewData);
        }
        if($request->isMethod('post')){
            //$request->imageでname属性を取得することで画像を取得できる
            $imageFile = $request->image;
            //画像がnullでなかったら && isValidでアップロードできたか判定
            if(!is_null($imageFile) && $imageFile->isValid()){
                //storageファサードのputFileメソッドでstorage配下のshopsフォルダ内に保存処理を行う
                Storage::putFile('public/shops', $imageFile);
            }
        }
        return redirect()->route('owner.shops.index');
    }

    // public function edit($id){
    //     $this->viewData['shop'] = Shop::findOrFail($id);
    //       return view('owner.shops.edit', $this->viewData);
    // }
    // public function update(Request $request,$id){
    //         $imageFile = $request->image;
    //         if(!is_null($imageFile) && $imageFile->isValid()){
    //             Storage::putFile('public/shops', $imageFile);
    //         }
    //         return redirect()->route('owner.shops.index');
    // }
}
