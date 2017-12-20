<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterAppConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_app_configurations', function (Blueprint $table) {
            $table->string('path_logo_app_configurations');
            $table->string('name_logo_app_configurations');
            $table->string('path_icon_app_configurations');
            $table->string('name_icon_app_configurations');
            $table->double('sessions_days_duration_app_configurations');
            $table->double('game_minutes_duration_app_configurations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_app_configurations');
    }
}
