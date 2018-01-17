<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_games', function (Blueprint $table) {
            $table->increments('id_games');
            $table->integer('sessions_id')->index();
            $table->datetime('start_date_games');
            $table->datetime('end_date_games');
            $table->double('status_active_games');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_games');
    }
}
