<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('request_type', 20);
            $table->integer('user_id')->unsigned();
            $table->integer('hardware_id')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->integer('admin_id')->unsigned();
            //$table->text('description');
            $table->timestamp('datetime_start');
            $table->timestamp('datetime_return');
            $table->string('status', 20); //wait=รออนุมัติ, approve=อนุมัติ, using=ใช้งาน, return=คืนเรียบร้อย, lost=สูญหาย
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
        Schema::drop('requests');
    }
}
