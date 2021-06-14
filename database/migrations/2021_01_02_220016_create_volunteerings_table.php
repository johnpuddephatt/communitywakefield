<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolunteeringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('volunteerings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subteam_id')->nullable()->constrained();
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->nullable()->constrained('users');

            $table->date('display_until')->nullable();
            $table->enum('status', ["Published","Draft"]);
            $table->string('title', 400);
            $table->string('slug', 400);
            $table->longText('content')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 60)->nullable();
            $table->boolean('from_home')->default(false)->nullable();
            $table->string('address', 600)->nullable();
            $table->string('postcode')->nullable();
            $table->string('address_ward', 100)->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('directions', 600)->nullable();
            $table->integer('places')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('hours', 400)->nullable();
            $table->date('deadline')->nullable();
            $table->smallInteger('minimum_age')->nullable();
            $table->smallInteger('maximum_age')->nullable();
            $table->string('expenses', 400)->nullable();
            $table->string('what_to_bring', 400)->nullable();
            $table->jsonb('requirements', 400)->nullable();
            $table->jsonb('skills_needed', 400)->nullable();
            $table->jsonb('skills_gained', 400)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteerings');
    }
}
