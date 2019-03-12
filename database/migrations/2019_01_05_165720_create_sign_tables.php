<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('balance')->default(0);
            $table->unsignedSmallInteger('point')->default(0);
            $table->timestamps();
        });
        Schema::create('sign_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->unsignedInteger('sign_id')->index();
            $table->foreign('sign_id')
                ->references('id')
                ->on('sign');
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
        Schema::dropIfExists('sign');
        Schema::dropIfExists('sign_logs');
    }
}
