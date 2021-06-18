<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSnils2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('snils2');
        });

        Schema::table('student_spos', function (Blueprint $table) {
            $table->string('snils2');
        });
        Schema::table('student_masters', function (Blueprint $table) {
            $table->string('snils2');
        });
        Schema::table('student_master_foreigners', function (Blueprint $table) {
            $table->string('snils2');
        });
        Schema::table('student_foreigners', function (Blueprint $table) {
            $table->string('snils2');
        });
        Schema::table('student_asps', function (Blueprint $table) {
            $table->string('snils2');
        });
        Schema::table('student_asp_foreigners', function (Blueprint $table) {
            $table->string('snils2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('snils2');
        });
        Schema::table('student_spos', function (Blueprint $table) {
            $table->dropColumn('snils2');
        });
        Schema::table('student_masters', function (Blueprint $table) {
            $table->dropColumn('snils2');
        });
        Schema::table('student_master_foreigners', function (Blueprint $table) {
            $table->dropColumn('snils2');
        });
        Schema::table('student_foreigners', function (Blueprint $table) {
            $table->dropColumn('snils2');
        });
        Schema::table('student_asps', function (Blueprint $table) {
            $table->dropColumn('snils2');
        });
        Schema::table('student_asp_foreigners', function (Blueprint $table) {
            $table->dropColumn('snils2');
        });
    }
}
