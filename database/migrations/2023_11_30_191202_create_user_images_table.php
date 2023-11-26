<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->string('imagePath')->nullable();
            $table->string('imageType')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('userId')
                ->references('userId')
                ->on('users')
                ->onDelete('cascade'); // Set the action on delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_images');
    }
}
