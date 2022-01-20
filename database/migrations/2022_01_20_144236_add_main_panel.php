<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainPanel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('infoblocks', function (Blueprint $table) {
            $table->boolean('mainMenu');
            $table->integer('mainMenuSort');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('infoblocks', function (Blueprint $table) {
            $table->dropColumn('mainMenu');
            $table->dropColumn('mainMenuSort');
        });
    }
}
