<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToForeigners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statistic_foreigners', function (Blueprint $table) {
            $table->boolean('acceptCount');
        });
        Schema::table('statistic_asp_foreigners', function (Blueprint $table) {
            $table->boolean('acceptCount');
        });
        Schema::table('statistic_master_foreigners', function (Blueprint $table) {
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
        Schema::table('statistic_foreigners', function (Blueprint $table) {
            $table->dropColumn('acceptCount');
        });
        Schema::table('statistic_asp_foreigners', function (Blueprint $table) {
            $table->dropColumn('acceptCount');
        });
        Schema::table('statistic_master_foreigners', function (Blueprint $table) {
            $table->dropColumn('acceptCount');
        });

    }
}
