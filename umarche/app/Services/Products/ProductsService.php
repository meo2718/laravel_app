<?php
namespace App\Services\Products;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Database\Query;


class ProductsService{

  public static function addByProduct($request){
    try {
      DB::beginTransaction();
      $product = Product::create([
        //左側がview(owner/products/create)からはいってくるname属性、secondaryだけ注意
        //quantityはstockテーブルなのでここには書かない
        'name' => $request->name,
        'information' => $request->information,
        'price' => $request->price,
        'sort_order' => $request->sort_order,
        'shop_id' => $request->shop_id,
        'secondary_category_id' => $request->category,
        'image1' => $request->image1,
        'image2' => $request->image2,
        'image3' => $request->image3,
        'image4' => $request->image4,
        'image5' => $request->image5,
        'is_selling' => $request->is_selling,
    ]);
    Stock::create([
      'product_id' => $product->id,
      'type' => 1,
      'quantity' => $request->quantity,
    ]);
    } catch (Exception $e) {
      Log::error($e);
      DB::rollback();
      return redirect()->route('owner.products.create');
    }
    DB::commit();
  }
}