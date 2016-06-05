<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHardwareCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            //$table->longText('description');
            //$table->string('slug')->unique();
            $table->string('type', 20); //material, equipment
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
        Schema::drop('hardware_category');
    }
}
