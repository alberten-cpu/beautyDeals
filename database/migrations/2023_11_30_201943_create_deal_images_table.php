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
        Schema::create('deal_images', function (Blueprint $table) {
            $table->unsignedBigInteger('dealId');
            $table->string('imagePath')->nullable();
            $table->string('imageType')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('dealId')
                ->references('dealId')
                ->on('deals')
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
        Schema::dropIfExists('deal_images');
    }
};
