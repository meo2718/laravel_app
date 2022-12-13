<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use InterventionImage;
use App\Http\Requests\UploadImageRequest;

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
    public function edit( UploadImageRequest $request, $id)
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
                //Storage::putFile('public/shops', $imageFile);リサイズなしの場合
                
                //uniqidを生成し、rand関数で重複しないランダムなファイル名を作成
                $fileName = uniqid(rand().'_');
                //dd($fileName);
                //アップロードしてきた画像$imageFileのextensionで拡張子を取得
                $extension = $imageFile->extension();
                //作成したファイル名と拡張子をくっつける
                $fileNameToStore = $fileName. '.' . $extension;
                //makeで使えるようにして必要な値として$imageFile→resizeでサイズ指定してencodeする
                $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
                //dd($imageFile,$resizedImage);

                //保存処理
                //Storage::putFileではFileオブジェクトを想定しており、InterventionImageでresizeすると
                //画像として扱われ、型が変わるのでStorage::putで保存する必要がある。
                //フォルダがない場合→自動生成。ファイル名は指定する必要がある。
                Storage::put('public/shops/' . $fileNameToStore, $resizedImage );
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
