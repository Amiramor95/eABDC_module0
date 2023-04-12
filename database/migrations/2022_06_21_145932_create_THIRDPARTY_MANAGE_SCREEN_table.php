<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTHIRDPARTYMANAGESCREENTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('THIRDPARTY_MANAGE_SCREEN', function (Blueprint $table) {
            $table->integer('THIRDPARTY_MANAGE_SCREEN_ID', true);
            $table->integer('THIRDPARTY_SUBMODULE_ID')->nullable();
            $table->integer('THIRDPARTY_MANAGE_MODULE_ID')->nullable();
            $table->string('THIRDPARTY_SCREEN_NAME', 100)->nullable();
            $table->string('THIRDPARTY_SCREEN_ROUTE', 100)->nullable();
            $table->integer('THIRDPARTY_SCREEN_PROCESS_ID')->nullable();
            $table->string('THIRDPARTY_SCREEN_DESC', 100)->nullable();
            $table->string('THIRDPARTY_SCREEN_CODE', 192)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('THIRDPARTY_MANAGE_SCREEN');
    }
}
