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
        Schema::create('venue_sub_category', function (Blueprint $table) {
            $table->bigIncrements('venueSubCategoryId');
            $table->unsignedBigInteger('venueCategoryId');
            $table->string('venueSubCategoryName');
            $table->boolean('venueSubCategoryStatus')->default(false);;
            $table->timestamps();
        });
        Schema::table('venue_sub_category', function (Blueprint $table) {

            $table->foreign('venueCategoryId')->references('venueCategoryId')->on('venue_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venue_sub_category');
        Schema::table('venue_sub_category', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');
        });


    }
};
