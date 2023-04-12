<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTAUTHORISATIONLEVELTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_AUTHORISATION_LEVEL', function (Blueprint $table) {
            $table->integer('CONSULTANT_AUTHORISATION_LEVEL_ID', true);
            $table->string('CONSULTANT_AUTHORISATION_LEVEL_NAME', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_AUTHORISATION_LEVEL');
    }
}
