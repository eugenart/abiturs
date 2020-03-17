<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('planId');
            $table->bigInteger('id_faculty');
            $table->bigInteger('id_studyForm');
            $table->bigInteger('id_speciality');
            $table->bigInteger('id_specialization')->nullable();
            $table->integer('years');
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
        Schema::dropIfExists('plan_masters');
    }
}
