<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoEn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_master_foreigners', function (Blueprint $table) {
            $table->string('info_en')->nullable();
        });
        Schema::table('price_asp_foreigners', function (Blueprint $table) {
            $table->string('info_en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_master_foreigners', function (Blueprint $table) {
            $table->dropColumn('info_en');
        });
        Schema::table('price_asp_foreigners', function (Blueprint $table) {
            $table->dropColumn('info_en');
        });
    }
}
