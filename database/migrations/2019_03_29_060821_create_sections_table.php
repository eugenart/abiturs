<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('url');
            $table->boolean('startPage')->default(true);
            $table->integer('startPagePriority')->default(500);
            $table->boolean('activity')->default(true);
            $table->date('activityFrom')->nullable();
            $table->date('activityTo')->nullable();
            $table->bigInteger('infoblockID')->nullable();
            $table->bigInteger('sectionID')->nullable();
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
        Schema::dropIfExists('sections');
    }
}
