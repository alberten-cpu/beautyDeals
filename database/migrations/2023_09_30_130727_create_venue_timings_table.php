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
        Schema::create('venue_timing', function (Blueprint $table) {
            $table->unsignedBigInteger('venueId'); // Use unsignedBigInteger to match the data type of venueId
            $table->foreign('venueId')->references('venueId')->on('venues')->onDelete('cascade');
            $table->string('day');
            $table->string('openTime')->nullable();
            $table->string('closeTime')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('venue_timing');
    }
};
