<?php

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
            $table->string('sdu_id')->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('tel', 20);
            $table->string('position', 250);
            $table->string('role', 10)->default('user');
            $table->string('avatar')->default('avatar_01.png');
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
