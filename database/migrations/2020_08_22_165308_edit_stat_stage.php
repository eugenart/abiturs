<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditStatStage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('statistics', function (Blueprint $table) {
            $table->string('stage')->nullable();
            $table->string('stage_title')->nullable();
        });
        Schema::table('statistic_asps', function (Blueprint $table) {
            $table->string('stage')->nullable();
            $table->string('stage_title')->nullable();
        });
		Schema::table('statistic_asp_foreigners', function (Blueprint $table) {
            $table->string('stage')->nullable();
            $table->string('stage_title')->nullable();
        });
		Schema::table('statistic_foreigners', function (Blueprint $table) {
            $table->string('stage')->nullable();
            $table->string('stage_title')->nullable();
        });
		Schema::table('statistic_masters', function (Blueprint $table) {
            $table->string('stage')->nullable();
            $table->string('stage_title')->nullable();
        });
		Schema::table('statistic_master_foreigners', function (Blueprint $table) {
            $table->string('stage')->nullable();
            $table->string('stage_title')->nullable();
        });
		Schema::table('statistic_spos', function (Blueprint $table) {
            $table->string('stage')->nullable();
            $table->string('stage_title')->nullable();
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
            $table->string('stage');
			$table->string('stage_title');
        });
		Schema::table('statistic_asps', function (Blueprint $table) {
            $table->string('stage');
			$table->string('stage_title');
        });
		Schema::table('statistic_asp_foreigners', function (Blueprint $table) {
            $table->string('stage');
			$table->string('stage_title');
        });
		Schema::table('statistic_foreigners', function (Blueprint $table) {
            $table->string('stage');
			$table->string('stage_title');
        });
		Schema::table('statistic_masters', function (Blueprint $table) {
            $table->string('stage');
			$table->string('stage_title');
        });
		Schema::table('statistic_master_foreigners', function (Blueprint $table) {
            $table->string('stage');
			$table->string('stage_title');
        });
		Schema::table('statistic_spos', function (Blueprint $table) {
            $table->string('stage');
			$table->string('stage_title');
        });
    }
}
