<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sup_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('year_of_company');
            $table->string('notif_bach')->nullable();
            $table->string('notif_bach_f')->nullable();
            $table->string('notif_bach_f_en')->nullable();
            $table->string('notif_master')->nullable();
            $table->string('notif_master_f')->nullable();
            $table->string('notif_master_f_en')->nullable();
            $table->string('notif_asp')->nullable();
            $table->string('notif_asp_f')->nullable();
            $table->string('notif_asp_f_en')->nullable();
            $table->string('notif_spo')->nullable();
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
        Schema::dropIfExists('sup_details');
    }
}
