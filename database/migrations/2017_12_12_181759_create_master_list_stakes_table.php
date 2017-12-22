<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterListStakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_list_stakes', function (Blueprint $table) {
            $table->increments('id_list_stakes');
            $table->string('name_list_stakes');
            $table->string('command_list_stakes');
            $table->string('path_image_list_stakes');
            $table->string('name_image_list_stakes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_list_stakes');
    }
}
