<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterCountryPhoneCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_country_phone_codes', function (Blueprint $table) {
            $table->increments('id_country_phone_codes');
            $table->string('name_country_phone_codes');
            $table->string('code_country_phone_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_country_phone_codes');
    }
}
