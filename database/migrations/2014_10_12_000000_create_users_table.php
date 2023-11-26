<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('userId');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('PhoneNumber')->nullable();
            $table->rememberToken();
            $table->boolean('isActive')->default(false);
            $table->boolean('isMember')->default(false);
            $table->unsignedBigInteger('roleId');
            $table->timestamp('last_seen')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('userId')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('userId')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('userId')->on('users')->onDelete('set null');
            $table->foreign('roleId')->references('roleId')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
