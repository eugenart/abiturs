<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_speciality');
            $table->string('trainingForm');
            $table->integer('freeSeatsNumber');
            $table->integer('years');
            $table->integer('price');
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
        Schema::dropIfExists('training_areas');
    }
}
