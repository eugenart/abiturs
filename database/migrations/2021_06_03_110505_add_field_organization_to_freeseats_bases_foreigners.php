<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldOrganizationToFreeseatsBasesForeigners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('freeseats_bases_foreigners', function (Blueprint $table) {
            $table->string('organization');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('freeseats_bases_foreigners', function (Blueprint $table) {
            $table->dropColumn('organization');
        });
    }
}
