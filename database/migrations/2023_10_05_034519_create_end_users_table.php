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
        Schema::create('end_user', function (Blueprint $table) {
            $table->unsignedBigInteger('userId');
            $table->string('name')->nullable();
            $table->string('suburb')->nullable();
            $table->string('dateOfBirth')->nullable();
            $table->boolean('userStatus')->default(true);
            $table->timestamps();

            $table->foreign('userId')
                ->references('userId')
                ->on('users')
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
