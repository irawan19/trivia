<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('bots_id')->index();
            $table->integer('sub_users_id')->index();
            $table->integer('level_systems_id')->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->double('phone_number_users');
            $table->double('credit_users');
            $table->double('max_group_users');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
