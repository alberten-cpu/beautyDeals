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
        Schema::create('deal_repeats', function (Blueprint $table) {
            $table->bigIncrements('repeatId');
            $table->unsignedBigInteger('dealId');
            $table->time('sTime');
            $table->time('eTime');
            $table->string('repeat');
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
        Schema::dropIfExists('deal_repeats');
    }
};
