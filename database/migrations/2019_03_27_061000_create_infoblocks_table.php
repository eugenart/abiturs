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
            $table->boolean('menu')->default(true);
            $table->boolean('start_page')->default(true);
            $table->integer('menu_priority')->default(500);
            $table->integer('start_page_priority')->default(500);
            $table->boolean('activity')->default(true);
            $table->date('activity_from')->nullable();
            $table->date('activity_to')->nullable();
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
