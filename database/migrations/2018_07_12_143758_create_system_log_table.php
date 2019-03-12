<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',255);
            $table->tinyInteger('level')->default(0);
            $table->string('title',255);
            $table->text('content');
            $table->string('operator_type',255)->nullable();
            $table->integer('operator_id')->default(0)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->ipAddress('ip')->nullable();
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
        Schema::dropIfExists('system_log');
    }
}
