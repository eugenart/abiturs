<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanCompetitionAspForeignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_competition_asp_foreigners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_plan');
            $table->bigInteger('id_competition');
            $table->integer('freeSeatsNumber');
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
        Schema::dropIfExists('plan_competition_asp_foreigners');
    }
}
