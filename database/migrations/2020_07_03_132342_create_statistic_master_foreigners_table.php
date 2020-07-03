<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticMasterForeignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic_master_foreigners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_student');
            $table->bigInteger('id_faculty');
            $table->bigInteger('id_speciality');
            $table->bigInteger('id_specialization')->nullable();
            $table->bigInteger('id_preparationLevel');
            $table->bigInteger('id_studyForm');
            $table->bigInteger('id_category');
            $table->bigInteger('id_admissionBasis');
            $table->boolean('accept');
            $table->boolean('original');
            $table->string('summ');
            $table->string('indAchievement');
            $table->string('summContest');
            $table->boolean('needHostel');
            $table->string('notice1')->nullable();
            $table->string('notice2')->nullable();
            $table->boolean('is_chosen');
            $table->bigInteger('id_plan');
            $table->bigInteger('id_competition');
            $table->boolean('foreigner');
            $table->boolean('yellowline');

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
        Schema::dropIfExists('statistic_master_foreigners');
    }
}
