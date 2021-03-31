<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteeringSuitabilitiesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_suitabilities_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger('volunteering_id');
            $table->foreign('volunteering_id')->references('id')->on('volunteerings');
            $table->unsignedBigInteger('volunteering_suitability_id');
            $table->foreign('volunteering_suitability_id')->references('id')->on('volunteering_suitabilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteering_suitabilities_pivot');
    }
}
