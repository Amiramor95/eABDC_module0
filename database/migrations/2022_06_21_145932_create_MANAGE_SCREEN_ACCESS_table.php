<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGESCREENACCESSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_SCREEN_ACCESS', function (Blueprint $table) {
            $table->integer('MANAGE_SCREEN_ACCESS_ID', true);
            $table->integer('MANAGE_GROUP_ID');
            $table->integer('AUTHORIZATION_LEVEL_ID');
            $table->string('MANAGE_SCREEN_ID', 500);
            $table->integer('USER_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_SCREEN_ACCESS');
    }
}
