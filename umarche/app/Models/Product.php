<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\Image;
use App\Models\SecondaryCategory;

class Product extends Model
{
    use HasFactory;

    public function shop()
    {   //productはshopに属する。
        return $this->belongsTo(Shop::class);
    }
    public function imageFirst()
    {   //productはImageに属する。
        return $this->belongsTo(Image::class,'image1','id');
    }
    public function category()
    {   //productはsecondaryCategoryに属する。メソッド名を変えたので外部キーもかく
        return $this->belongsTo(SecondaryCategory::class,'secondary_category_id');
    }
}
