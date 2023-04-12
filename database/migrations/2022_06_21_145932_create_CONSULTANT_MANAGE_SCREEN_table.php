<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTMANAGESCREENTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_MANAGE_SCREEN', function (Blueprint $table) {
            $table->integer('CONSULTANT_MANAGE_SCREEN_ID', true);
            $table->integer('CONSULTANT_MODULE_ID')->nullable();
            $table->integer('CONSULTANT_MANAGE_SUBMODULE_ID')->nullable();
            $table->string('CONSULTANT_SCREEN_NAME', 100)->nullable();
            $table->string('CONSULTANT_SCREEN_ROUTE', 100)->nullable();
            $table->integer('CONSULTANT_SCREEN_PROCESS_ID')->nullable();
            $table->string('CONSULTANT_SCREEN_DESC', 100)->nullable();
            $table->string('CONSULTANT_SCREEN_CODE', 192)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_MANAGE_SCREEN');
    }
}
