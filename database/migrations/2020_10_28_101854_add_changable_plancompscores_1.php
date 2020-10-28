<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChangablePlancompscores1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_comp_scores', function (Blueprint $table) {
            $table->boolean('changeable');
        });
        Schema::table('plan_comp_score_foreigners', function (Blueprint $table) {
            $table->boolean('changeable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_comp_scores', function (Blueprint $table) {
            $table->dropColumn('changeable');
        });
        Schema::table('plan_comp_score_foreigners', function (Blueprint $table) {
            $table->dropColumn('changeable');
        });
    }
}
