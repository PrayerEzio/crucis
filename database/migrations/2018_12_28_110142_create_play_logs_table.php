<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('play_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('play_id')->unique();
            $table->unsignedInteger('room_id')->unique();
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->text('machine_token');
            $table->unsignedSmallInteger('cost_coin')->default(0);
            $table->unsignedSmallInteger('get_coin')->default(0);
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
        Schema::dropIfExists('play_logs');
    }
}
