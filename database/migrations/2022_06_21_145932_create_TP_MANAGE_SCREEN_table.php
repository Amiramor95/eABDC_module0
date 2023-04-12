<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPMANAGESCREENTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TP_MANAGE_SCREEN', function (Blueprint $table) {
            $table->integer('TP_MANAGE_SCREEN_ID', true);
            $table->integer('TP_MANAGE_SUBMODULE_ID')->nullable();
            $table->integer('TP_MANAGE_MODULE_ID');
            $table->string('TP_SCREEN_NAME', 100)->nullable();
            $table->string('TP_SCREEN_ROUTE', 100)->nullable();
            $table->integer('TP_SCREEN_PROCESS_ID')->nullable();
            $table->string('TP_SCREEN_DESC', 100)->nullable();
            $table->string('TP_SCREEN_CODE', 192)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TP_MANAGE_SCREEN');
    }
}
