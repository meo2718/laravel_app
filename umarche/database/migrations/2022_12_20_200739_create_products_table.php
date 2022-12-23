<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     * 親を削除したときに合わせて削除するか
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('informatiom');
            $table->unsignedInteger('price');
            $table->boolean('is_selling');
            $table->integer('sort_order')->nullable();
            //ownerを削除したらshopも消える、shopが消えたらproductも消えるようにする→cascade
            $table->foreignId('shop_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('secondary_category_id')->constrained();
            //モデル名_idとすることでLaravelが自動でどのモデルか推測してくれるがimage1はできないので、constrained('images')どのモデルか指定する
            //画像はからの場合もあるのでnullableをつける
            $table->foreignId('image1')->nullable()->constrained('images');
            $table->foreignId('image2')->nullable()->constrained('images');
            $table->foreignId('image3')->nullable()->constrained('images');
            $table->foreignId('image4')->nullable()->constrained('images');
            $table->foreignId('image5')->nullable()->constrained('images');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
