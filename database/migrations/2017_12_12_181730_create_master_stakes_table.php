<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterStakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_stakes', function (Blueprint $table) {
            $table->increments('id_stakes');
            $table->integer('games_id')->index();
            $table->integer('register_members_id')->index();
            $table->integer('list_stakes_id')->index();
            $table->double('value_stakes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_stakes');
    }
}
