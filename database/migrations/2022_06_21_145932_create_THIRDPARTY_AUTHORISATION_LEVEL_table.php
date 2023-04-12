<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTHIRDPARTYAUTHORISATIONLEVELTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('THIRDPARTY_AUTHORISATION_LEVEL', function (Blueprint $table) {
            $table->integer('THIRDPARTY_AUTHORISATION_LEVEL_ID');
            $table->string('THIRDPARTY_AUTHORISATION_LEVEL_NAME', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('THIRDPARTY_AUTHORISATION_LEVEL');
    }
}
