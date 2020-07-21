<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnNamesNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->string('en_name')->nullable()->change();
        });
        Schema::table('specialities', function (Blueprint $table) {
            $table->string('en_name')->nullable()->change();
        });
        Schema::table('specializations', function (Blueprint $table) {
            $table->string('en_name')->nullable()->change();
        });
        Schema::table('study_forms', function (Blueprint $table) {
            $table->string('en_name')->nullable()->change();
        });
        Schema::table('subjects', function (Blueprint $table) {
            $table->string('en_name')->nullable()->change();
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
