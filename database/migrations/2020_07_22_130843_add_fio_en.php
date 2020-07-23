<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFioEn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_foreigners', function (Blueprint $table) {
            $table->string('fio_en')->nullable();
        });
        Schema::table('student_asp_foreigners', function (Blueprint $table) {
            $table->string('fio_en')->nullable();
        });
        Schema::table('student_master_foreigners', function (Blueprint $table) {
            $table->string('fio_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_foreigners', function (Blueprint $table) {
            $table->dropColumn('fio_en');
        });
        Schema::table('student_asp_foreigners', function (Blueprint $table) {
            $table->dropColumn('fio_en');
        });
        Schema::table('student_master_foreigners', function (Blueprint $table) {
            $table->dropColumn('fio_en');
        });
    }
}
