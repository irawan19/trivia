<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterRegisterMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_register_members', function (Blueprint $table) {
            $table->increments('id_register_members');
            $table->integer('sessions_id')->index();
            $table->integer('register_members_id')->index();
            $table->double('credit_register_members');
            $table->double('phone_number_register_members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_register_members');
    }
}
