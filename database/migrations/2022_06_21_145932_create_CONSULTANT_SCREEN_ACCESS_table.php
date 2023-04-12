<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTSCREENACCESSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_SCREEN_ACCESS', function (Blueprint $table) {
            $table->integer('CONSULTANT_SCREEN_ACCESS_ID', true);
            $table->integer('CONSULTANT_MANAGE_GROUP_ID');
            $table->integer('CONSULTANT_AUTHORISATION_LEVEL_ID');
            $table->string('CONSULTANT_SCREEN_ID', 100);
            $table->integer('CONSULTANT_USER_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_SCREEN_ACCESS');
    }
}
