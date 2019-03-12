<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //商品分类表
        Schema::create('goods_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id')->default(0);
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        //商品表
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('goods_category');
            $table->string('name');
            $table->string('sub_title')->nullable();
            $table->string('picture')->nullable();
            $table->text('detail');
            $table->softDeletes();
            $table->timestamps();
        });

        //产品表
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_id');
            $table->foreign('goods_id')
                ->references('id')
                ->on('goods')
                ->onDelete('cascade');
            $table->integer('stock')->unsiged()->default(0);
            $table->decimal('price',8,2)->unsigned();
            $table->tinyInteger('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        //产品属性分类表
        Schema::create('attribute_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        //产品属性表
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('attribute_category');
            $table->string('value');
            $table->timestamps();
        });

        //产品属性关联表
        Schema::create('product_attribute', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('attribute_id');
            $table->foreign ('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes');
            $table->primary(['product_id', 'attribute_id']);
        });

        //商品图片表
        Schema::create('goods_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_id');
            $table->foreign('goods_id')
                ->references('id')
                ->on('goods')
                ->onDelete('cascade');
            $table->string('url');
            $table->tinyInteger('sort')->unsigned()->default(0);
            $table->tinyInteger('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        //商品评论表
        Schema::create('goods_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_id');
            $table->foreign('goods_id')
                ->references('id')
                ->on('goods');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->text('content');
            $table->tinyInteger('sort')->unsigned()->default(0);
            $table->tinyInteger('status')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('goods_category');
        Schema::dropIfExists('goods');
        Schema::dropIfExists('products');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('attribute_category');
        Schema::dropIfExists('product_attribute');
        Schema::dropIfExists('goods_pictures');
        Schema::dropIfExists('goods_comments');
    }
}
