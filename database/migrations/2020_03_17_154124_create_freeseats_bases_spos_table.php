<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreeseatsBasesSposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freeseats_bases_spos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_plan_comp');
            $table->bigInteger('id_admissionBasis');
            $table->integer('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freeseats_bases_spos');
    }
}
