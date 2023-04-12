<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGESCREENTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_SCREEN', function (Blueprint $table) {
            $table->integer('MANAGE_SCREEN_ID', true);
            $table->integer('MANAGE_SUBMODULE_ID')->index('SUBMOD_ID');
            $table->string('SCREEN_NAME', 100)->nullable();
            $table->string('SCREEN_ROUTE', 500);
            $table->string('SCREEN_PROCESS', 500)->nullable();
            $table->string('SCREEN_DESCRIPTION', 500);
            $table->string('SCREEN_CODE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_SCREEN');
    }
}
