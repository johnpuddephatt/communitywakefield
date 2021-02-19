<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessibles', function (Blueprint $table) {
            $table->unsignedBigInteger('accessibility_id');
            $table->foreign('accessibility_id')->references('id')->on('accessibilities');
            $table->unsignedBigInteger('accessible_id');
            $table->string('accessible_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accessibles');
    }
}
