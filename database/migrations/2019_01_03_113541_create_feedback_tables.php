<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //反馈表
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->text('content');
            $table->softDeletes();
            $table->timestamps();
        });
        //反馈图片表
        Schema::create('feedbacks_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('feedback_id')->index();
            $table->foreign('feedback_id')
                ->references('id')
                ->on('feedbacks')
                ->onDelete('cascade');
            $table->text('url');
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
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('feedbacks_pictures');
    }
}
