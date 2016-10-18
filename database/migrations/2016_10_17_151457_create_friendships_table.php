<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendshipsTable extends Migration
{
    public function up()
    {
        Schema::create('friendships', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('friend_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('friend_id')->references('id')->on('users');
            $table->enum('status', ['pending', 'requested', 'accepted']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('friendships');
    }
}
