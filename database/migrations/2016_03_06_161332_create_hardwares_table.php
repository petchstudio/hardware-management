<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardwares', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hardware_id');
            $table->string('name');
            $table->string('responsible');
            $table->integer('brand');
            //$table->integer('brand_id');
            $table->string('model', 250);
            $table->integer('category_id');
            $table->integer('place_id');
            $table->integer('status');      // 0=ปกติ, 1=กำลังใช้, 2=เสีย
            $table->integer('quantity')->unsigned();
            $table->integer('quantity_use')->unsigned()->default(0);
            $table->string('type', 20);     // materials, equipment
            $table->string('note');
            $table->dateTime('get_at');
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
        Schema::drop('hardwares');
    }
}
