<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORAUTHORISATIONLEVELTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_AUTHORISATION_LEVEL', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_AUTHORISATION_LEVEL_ID', true);
            $table->string('DISTRIBUTOR_AUTHORISATION_LEVEL_NAME', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DISTRIBUTOR_AUTHORISATION_LEVEL');
    }
}
