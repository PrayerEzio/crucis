<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',32)->default('');
            $table->string('cipher',64)->default('');
            $table->string('cover',255)->nullable();
            $table->mediumInteger('numbers')->unsigned()->default(0);
            $table->integer('time_limit')->unsigned()->default(0);
            $table->integer('user_id')->unsigned()->default(0);
            $table->boolean('is_private')->unsigned()->default(0);
            $table->tinyInteger('status')->unsigned()->default(0);
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
        Schema::dropIfExists('room');
    }
}
