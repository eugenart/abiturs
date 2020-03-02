<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanCompScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_comp_scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_plan_comp');
            $table->bigInteger('id_subject');
            $table->integer('minScore');
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
        Schema::dropIfExists('plan_comp_scores');
    }
}
