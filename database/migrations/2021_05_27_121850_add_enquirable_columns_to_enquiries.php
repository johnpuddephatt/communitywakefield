<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnquirableColumnsToEnquiries extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table("enquiries", function (Blueprint $table) {
      $table->integer("enquirable_id");
      $table->string("enquirable_type");
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table("enquiries", function (Blueprint $table) {
      //
    });
  }
}
