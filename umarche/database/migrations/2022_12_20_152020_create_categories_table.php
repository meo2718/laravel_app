<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   //schema::create('テーブル名')
        Schema::create('primary_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order');
            $table->timestamps();
        });

        Schema::create('secondary_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_order');
            //外部キーFK設定
            $table->foreignId('primary_category_id')->constrained();
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
        //migate:refreshなどのコードでテーブルを削除する処理を書く
        //secondaryテーブルから先に削除しないと外部キーエラーになるので注意
        Schema::dropIfExists('secondary_categories');
        Schema::dropIfExists('primary_categories');
    }
}
