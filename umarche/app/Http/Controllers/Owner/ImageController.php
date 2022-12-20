<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UploadImageRequest;
use App\Services\Image\ImageService;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners'); 

        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameter('image');
            if(!is_null($id)){
            $imagesOwnerId = Image::findOrFail($id)->owner->id;
              $imageId = (int)$imagesOwnerId;
              if($imageId !== Auth::id()){
              abort(404);
              }
            }
            return $next($request);
        });
    }

    public function index()
    {
        $this->viewData['images'] = Image::where('owner_id', Auth::id())
        ->orderBy('updated_at','desc')
        ->paginate(20);
        return view('owner.images.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owner.images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadImageRequest $request)
    {
        //create.blade側のinputのname属性filesを引数とすることで、複数の画像を配列形式で取得
        $imageFiles = $request->file('files');
        if(is_null($imageFiles)){
            return redirect()->route('owner.images.create')->with(['message' => 'ファイルを選択してください。','status'=>'info']);
        }elseif(!is_null($imageFiles)){
            //foreachで1つずつImageServiceでファイル名作る→拡張子取得→interventionImageでリサイズ
            //出来上がったファイル名を$fileNameToStoreとして取得し、createで保存
            foreach($imageFiles as $imageFile){
                $fileNameToStore = ImageService::addByImage($imageFile, 'products');
                 Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore
                 ]);
            }
        }
        return redirect()->route('owner.images.index')->with(['message' => '画像登録を実施しました。','status'=>'info']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->viewData['image'] = Image::findOrFail($id);
        return view('owner.images.edit', $this->viewData);
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
        $request->validate([
            'title' => 'string|max:50',
        ]);
        $image = Image::findOrFail($id);
        //$request->titleカラムの値取得
        $image->title = $request->title;

        $image->save();
        return redirect()->route('owner.images.index')->with(['message' => '画像情報を更新しました。','status'=>'info']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //削除処理の前にstorageの中の画像を削除する必要がある
        $image = Image::findOrFail($id);
        //ファイルパス、ファイル名をくっつけて取得
        $filePath = 'public/products/'.$image->filename;
        //ファイルが存在する確認し、なかったら消す
        if(Storage::exists($filePath)){
            Storage::delete($filePath);
        }
        //ファイルが消えたらImageテーブルの情報も削除
        Image::findOrFail($id)->delete();
        return redirect()->route('owner.images.index')->with(['message' => '画像を削除しました。','status'=>'alert']);
    }
}
