<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->string('en_name');
        });
        Schema::table('specialities', function (Blueprint $table) {
            $table->string('en_name');
        });
        Schema::table('specializations', function (Blueprint $table) {
            $table->string('en_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->dropColumn('en_name');
        });
        Schema::table('specialities', function (Blueprint $table) {
            $table->dropColumn('en_name');
        });
        Schema::table('specializations', function (Blueprint $table) {
            $table->dropColumn('en_name');
        });
    }
}
