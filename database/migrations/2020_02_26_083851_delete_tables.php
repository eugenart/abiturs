<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('training_areas');
        Schema::dropIfExists('training_areas_subjects');
        Schema::dropIfExists('faculty_areas');
        Schema::dropIfExists('statistics_extras');
        Schema::dropIfExists('statistics_intras');
        Schema::dropIfExists('statistics_parts');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
