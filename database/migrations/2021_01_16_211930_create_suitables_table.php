<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuitablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suitables', function (Blueprint $table) {
            $table->unsignedBigInteger('suitability_id');
            $table->foreign('suitability_id')->references('id')->on('suitabilities');
            $table->unsignedBigInteger('suitable_id');
            $table->string('suitable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suitables');
    }
}
