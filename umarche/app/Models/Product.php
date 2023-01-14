<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shop;
use App\Models\Image;
use App\Models\Stock;
use App\Models\SecondaryCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function users()
    {
        return $this->belongsToMany(User::class,'carts')
        ->withPivot(['id', 'quantity']);
    }

    public function scopeAvailableItems($query)
    {
        $stocks = DB::table('t_stocks') 
        ->select('product_id', DB::raw('sum(quantity) as quantity')) 
        ->groupBy('product_id') 
        ->having('quantity', '>', 1);
        return $query

        ->joinSub($stocks, 'stock', function($join){
        //さらにproductとshopテーブルをjoinでつなげる
        $join->on('products.id', '=', 'stock.product_id'); })
        ->join('shops', 'products.shop_id', '=', 'shops.id')
        ->join('secondary_categories', 'products.secondary_category_id', '=', 'secondary_categories.id')
        ->join('images as image1', 'products.image1', '=', 'image1.id')
        //shopsとproductsのis_sellingがtrueならgetする
        ->where('shops.is_selling', true)
        ->where('products.is_selling', true)
        ->select('products.id as id', 'products.name as name', 'products.price' ,'products.sort_order as sort_order',
        'products.information', 'secondary_categories.name as category' ,'image1.filename as filename');
    }
}
