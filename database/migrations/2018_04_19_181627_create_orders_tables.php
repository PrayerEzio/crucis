<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->string('name');
            $table->string('phone',16);
            $table->unsignedInteger('province_id');
            $table->foreign('province_id')
                ->references('id')
                ->on('regions');
            $table->unsignedInteger('city_id');
            $table->foreign('city_id')
                ->references('id')
                ->on('regions');
            $table->unsignedInteger('district_id');
            $table->foreign('district_id')
                ->references('id')
                ->on('regions');
            $table->text('address');
            $table->string('tag',32)->default('');
            $table->unsignedTinyInteger('sort')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->char('order_sn',16)->index();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->unsignedInteger('address_id')->default(0)->index();
            $table->unsignedDecimal('freight')->default(0);
            $table->unsignedDecimal('amount')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('order_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->string('goods_name');
            $table->unsignedDecimal('mkt_price')->default(0);
            $table->unsignedDecimal('price');
            $table->unsignedSmallInteger('qty')->default(0);
            $table->string('picture')->nullable();
        });
        Schema::create('order_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
            $table->string('operator');
            $table->string('title');
            $table->string('content');
            $table->ipAddress('ip')->default('');
            $table->unsignedTinyInteger('level');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_products');
        Schema::dropIfExists('order_logs');
    }
}
