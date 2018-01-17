<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterTopUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_top_ups', function (Blueprint $table) {
            $table->increments('id_top_ups');
            $table->integer('from_users_id')->index();
            $table->integer('to_users_id')->index();
            $table->integer('to_register_members_id')->index();
            $table->integer('to_groups_id')->index();
            $table->date('date_top_ups');
            $table->time('time_top_ups');
            $table->double('credit_top_ups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_top_ups');
    }
}
