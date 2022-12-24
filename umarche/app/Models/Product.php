<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\Image;
use App\Models\Stock;
use App\Models\SecondaryCategory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'information',
        'price',
        'is_selling',
        'sort_order',
        'shop_id',
        'secondary_category_id',
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
    ];

    public function shop()
    {   //productはshopに属する。
        return $this->belongsTo(Shop::class);
    }
    public function imageFirst()
    {   //productはImageに属する。
        return $this->belongsTo(Image::class,'image1','id');
    }
    public function imageSecond()
    {   //productはImageに属する。
        return $this->belongsTo(Image::class,'image2','id');
    }
    public function imageThird()
    {   //productはImageに属する。
        return $this->belongsTo(Image::class,'image3','id');
    }
    public function imageFourth()
    {   //productはImageに属する。
        return $this->belongsTo(Image::class,'image4','id');
    }
    public function imageFifth()
    {   //productはImageに属する。
        return $this->belongsTo(Image::class,'image5','id');
    }
    public function category()
    {   //productはsecondaryCategoryに属する。メソッド名を変えたので外部キーもかく
        return $this->belongsTo(SecondaryCategory::class,'secondary_category_id');
    }
    public function stock()
    {   //1つのproductが複数のStockをもつ
        return $this->hasMany(Stock::class);
    }
}
