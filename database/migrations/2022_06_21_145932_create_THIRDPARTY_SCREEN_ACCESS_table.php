<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTHIRDPARTYSCREENACCESSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('THIRDPARTY_SCREEN_ACCESS', function (Blueprint $table) {
            $table->integer('THIRDPARTY_SCREEN_ACCESS_ID', true);
            $table->integer('THIRDPARTY_MANAGE_GROUP_ID');
            $table->integer('THIRDPARTY_AUTHORISATION_LEVEL_ID');
            $table->string('THIRDPARTY_SCREEN_ID', 100);
            $table->integer('THIRDPARTY_USER_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('THIRDPARTY_SCREEN_ACCESS');
    }
}
