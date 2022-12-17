<?php
namespace App\Services\Image;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

Class ImageService
{
  public static function addByImage($imageFile,$folderName){
    //dd($imageFile['image']);
    //配列だった場合、$imageFile['image']とすることで配列を取得できる
    if(is_array($imageFile)){
      $file = $imageFile['image'];
    }else{
      $file = $imageFile;
    }
    $fileName = uniqid(rand().'_');
    //配列だった場合、$imageFile['image']としてるので拡張子がとれる
    $extension = $file->extension();
    $fileNameToStore = $fileName. '.' . $extension;
    //配列だった場合、$imageFile['image']としてるのでリサイズ可能
    $resizedImage = InterventionImage::make($file)->resize(1920, 1080)->encode();  
    Storage::put('public/'. $folderName . '/' . $fileNameToStore, $resizedImage );

    return $fileNameToStore;
  }
}
