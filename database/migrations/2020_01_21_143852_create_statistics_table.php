<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_student');
            $table->bigInteger('id_faculty');
            $table->bigInteger('id_speciality');
            $table->bigInteger('id_specialization');
            $table->string('preparationLevel');
            $table->string('admissionBasis');
            $table->string('studyForm');
            $table->string('category');
            $table->boolean('accept');
            $table->boolean('original');
            $table->string('summ');
            $table->string('indAchievement');
            $table->string('summContest');
            $table->boolean('needHostel');
            $table->string('notice1');
            $table->string('notice2');


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
        Schema::dropIfExists('statistics');
    }
}
