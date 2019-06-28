<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoblocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infoblocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('url');
            $table->string('news')->nullable();
            $table->boolean('menu')->default(true);
            $table->boolean('startPage')->default(true);
            $table->integer('menuPriority')->default(500);
            $table->integer('startPagePriority')->default(500);
            $table->boolean('activity')->default(true);
            $table->date('activityFrom')->nullable();
            $table->date('activityTo')->nullable();
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
        Schema::dropIfExists('infoblocks');
    }
}
