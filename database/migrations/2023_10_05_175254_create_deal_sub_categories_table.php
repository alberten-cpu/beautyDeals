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
        Schema::create('deal_sub_category', function (Blueprint $table) {
            $table->bigIncrements('dealSubCategoryId');
            $table->unsignedBigInteger('dealCategoryId');
            $table->string('dealSubCategoryName');
            $table->boolean('dealSubCategoryStatus')->default(true);
            $table->timestamps();
            $table->foreign('dealCategoryId')
                ->references('categoryId')
                ->on('deal_category')
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
        Schema::dropIfExists('venue_category');
    }
};
