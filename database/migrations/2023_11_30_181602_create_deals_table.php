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
        Schema::create('deals', function (Blueprint $table) {
            $table->bigIncrements('dealId');
            $table->unsignedBigInteger('venueId');
            $table->text('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category')->nullable();
            $table->unsignedBigInteger('subCategory')->nullable();
            $table->string('price')->nullable();
            $table->timestamp('startDate')->nullable();
            $table->integer('isRepeat');
            $table->string('repeatWeeks')->nullable();
            $table->timestamp('repeatEndDate')->nullable();
            $table->boolean('isExclusive')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('venueId')
                ->references('venueId')
                ->on('venues')
                ->onDelete('cascade');

            $table->foreign('category')
                ->references('categoryId')
                ->on('deal_category')
                ->nullOnDelete();

            $table->foreign('subCategory')
                ->references('dealSubCategoryId')
                ->on('deal_sub_category')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deals');
    }
};
