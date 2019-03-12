<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGoodsSnToGoodsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->char('goods_sn')->index();
            $table->text('tag')->nullable();
            $table->text('description')->nullable();
            $table->text('seo_title')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->text('seo_description')->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->char('product_sn')->index();
            $table->decimal('mkt_price',8,2)->unsigned();
            $table->text('position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn(['goods_sn','tag','description','seo_title','seo_keywords','seo_description']);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['product_sn','mkt_price','position']);
        });
    }
}
