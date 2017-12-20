<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_sessions', function (Blueprint $table) {
            $table->increments('id_sessions');
            $table->integer('groups_id')->index();
            $table->datetime('start_date_sessions');
            $table->datetime('end_date_sessions');
            $table->double('max_member_sessions');
            $table->double('credit_member_sessions');
            $table->double('status_active_sessions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_sessions');
    }
}
