<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('inviter_id')->index();
            $table->foreign('inviter_id')
                ->references('id')
                ->on('users');
            $table->unsignedInteger('invitee_id')->index();
            $table->foreign('invitee_id')
                ->references('id')
                ->on('users');
            $table->unsignedTinyInteger('stage')->default(0);
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
        Schema::dropIfExists('user_invitations');
    }
}
