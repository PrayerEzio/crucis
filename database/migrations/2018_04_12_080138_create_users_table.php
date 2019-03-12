<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname',255);
            $table->string('email',255)->nullable();
            $table->string('phone',16)->nullable();
            $table->string('avatar',255)->nullable();
            $table->string('password',255);
            $table->unsignedDecimal('balance')->default(0);
            $table->ipAddress('register_ip')->default('');
            $table->string('token',255)->nullable();
            $table->tinyInteger('status');
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
        Schema::dropIfExists('users');
    }
}
