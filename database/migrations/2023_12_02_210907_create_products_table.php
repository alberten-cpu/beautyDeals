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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('venueId');
            $table->text('title');
            $table->text('description')->nullable();
            $table->string('price')->nullable();
            $table->timestamp('startDate')->nullable();
            $table->timestamp('endDate')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('venueId')
                ->references('venueId')
                ->on('venues')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
