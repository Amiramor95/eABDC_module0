<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAUTHORIZATIONLEVELTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AUTHORIZATION_LEVEL', function (Blueprint $table) {
            $table->integer('AUTHORIZATION_LEVEL_ID', true);
            $table->string('AUTHORIZATION_LEVEL_NAME', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('AUTHORIZATION_LEVEL');
    }
}
