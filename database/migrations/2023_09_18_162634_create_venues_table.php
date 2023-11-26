<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->bigIncrements('venueId');
            $table->unsignedBigInteger('userId');
            $table->string('venueName');
            $table->string('venueDescription');
            $table->string('venueType');
            $table->string('venueWebsite')->nullable();
            $table->string('venueAddress')->nullable();
            $table->unsignedBigInteger('suburbId');
            $table->boolean('venueStatus')->default(false);
            $table->timestamp('last_seen')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Define foreign key constraints
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
            $table->foreign('suburbId')->references('id')->on('suburbs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venues');
    }
};
