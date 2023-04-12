<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPAUTHORISATIONLEVELTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TP_AUTHORISATION_LEVEL', function (Blueprint $table) {
            $table->integer('TP_AUTHORISATION_LEVEL_ID', true);
            $table->string('TP_AUTHORISATION_LEVEL_NAME', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TP_AUTHORISATION_LEVEL');
    }
}
