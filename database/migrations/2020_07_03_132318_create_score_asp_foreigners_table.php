<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreAspForeignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_asp_foreigners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_statistic');
            $table->bigInteger('id_subject');
            $table->string('score');
            $table->integer('priority');
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
        Schema::dropIfExists('score_asp_foreigners');
    }
}
