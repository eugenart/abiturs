<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSnils extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('snils');
        });

        Schema::table('student_spos', function (Blueprint $table) {
            $table->string('snils');
        });
        Schema::table('student_masters', function (Blueprint $table) {
            $table->string('snils');
        });
        Schema::table('student_master_foreigners', function (Blueprint $table) {
            $table->string('snils');
        });
        Schema::table('student_foreigners', function (Blueprint $table) {
            $table->string('snils');
        });
        Schema::table('student_asps', function (Blueprint $table) {
            $table->string('snils');
        });
        Schema::table('student_asp_foreigners', function (Blueprint $table) {
            $table->string('snils');
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
            $table->dropColumn('snils');
        });
        Schema::table('student_spos', function (Blueprint $table) {
            $table->dropColumn('snils');
        });
        Schema::table('student_masters', function (Blueprint $table) {
            $table->dropColumn('snils');
        });
        Schema::table('student_master_foreigners', function (Blueprint $table) {
            $table->dropColumn('snils');
        });
        Schema::table('student_foreigners', function (Blueprint $table) {
            $table->dropColumn('snils');
        });
        Schema::table('student_asps', function (Blueprint $table) {
            $table->dropColumn('snils');
        });
        Schema::table('student_asp_foreigners', function (Blueprint $table) {
            $table->dropColumn('snils');
        });
    }
}
