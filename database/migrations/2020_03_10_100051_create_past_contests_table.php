<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('past_contests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_studyForm');
            $table->bigInteger('id_admissionBasis');
            $table->bigInteger('id_speciality');
            $table->string('year');
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
        Schema::dropIfExists('past_contests');
    }
}
