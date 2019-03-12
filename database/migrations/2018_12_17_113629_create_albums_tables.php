<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //相册表
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->unsignedInteger('admin_id');
            $table->foreign('admin_id')
                ->references('id')
                ->on('admins');
            $table->text('image')->nullable();
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('is_private')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        //相册图片表
        Schema::create('albums_picture', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('album_id');
            $table->foreign('album_id')
                ->references('id')
                ->on('albums');
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('picture')->nullable();
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
        Schema::dropIfExists('albums');
        Schema::dropIfExists('albums_picture');
    }
}
