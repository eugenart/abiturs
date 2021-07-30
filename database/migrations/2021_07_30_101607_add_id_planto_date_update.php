<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdPlantoDateUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('date_updates', function (Blueprint $table) {
            $table->string('id_plan');
            $table->string('id_competition');
            $table->string('id_admissionBasis');
            $table->string('id_studyForm');
            $table->string('id_category');
            $table->string('id_preparationLevel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('date_updates', function (Blueprint $table) {
            $table->dropColumn('id_plan');
            $table->dropColumn('id_competition');
            $table->dropColumn('id_admissionBasis');
            $table->dropColumn('id_studyForm');
            $table->dropColumn('id_category');
            $table->dropColumn('id_preparationLevel');
        });
    }
}
