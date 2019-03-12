<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->char('first_letter',8)->nullable();
            $table->unsignedTinyInteger('level');
            $table->unsignedTinyInteger('is_hot')->default(0);
            $table->integer('parent_id')->default(0);
            $table->unsignedTinyInteger('is_special')->default(0);
            $table->unsignedInteger('sort')->default(0);
            $table->unsignedTinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
