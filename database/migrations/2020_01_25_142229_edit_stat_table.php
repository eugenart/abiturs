<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditStatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->bigInteger('id_preparationLevel');
            $table->bigInteger('id_studyForm');
            $table->bigInteger('id_category');
            $table->bigInteger('id_admissionBasis');
            $table->dropColumn('preparationLevel');
            $table->dropColumn('admissionBasis');
            $table->dropColumn('studyForm');
            $table->dropColumn('category');
        });
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
