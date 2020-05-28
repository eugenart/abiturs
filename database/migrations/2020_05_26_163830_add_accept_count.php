<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAcceptCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->boolean('acceptCount');
        });
        Schema::table('statistic_asps', function (Blueprint $table) {
            $table->boolean('acceptCount');
        });
        Schema::table('statistic_masters', function (Blueprint $table) {
            $table->boolean('acceptCount');
        });
        Schema::table('statistic_spos', function (Blueprint $table) {
            $table->boolean('acceptCount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statistics', function (Blueprint $table) {
            $table->dropColumn('acceptCount');
        });
        Schema::table('statistic_asps', function (Blueprint $table) {
            $table->dropColumn('acceptCount');
        });
        Schema::table('statistic_masters', function (Blueprint $table) {
            $table->dropColumn('acceptCount');
        });
        Schema::table('statistic_spos', function (Blueprint $table) {
            $table->dropColumn('acceptCount');
        });
    }
}
