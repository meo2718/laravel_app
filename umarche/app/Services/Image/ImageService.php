<?php
namespace App\Services\Image;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

Class ImageService
{
  public static function addByImage($imageFile,$folderName){
    $fileName = uniqid(rand().'_');          
    $extension = $imageFile->extension();
    $fileNameToStore = $fileName. '.' . $extension;               
    $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();  
    Storage::put('public/'. $folderName . '/' . $fileNameToStore, $resizedImage );

    return $fileNameToStore;
  }
}
