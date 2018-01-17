<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterBotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_bots', function (Blueprint $table) {
            $table->increments('id_bots');
            $table->integer('country_phone_codes_id');
            $table->date('date_register_bots');
            $table->time('time_register_bots');
            $table->string('name_bots');
            $table->double('phone_number_bots');
            $table->string('code_bots');
            $table->string('password_bots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_bots');
    }
}
