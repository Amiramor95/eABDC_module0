<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORMANAGESCREENTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_MANAGE_SCREEN', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_MANAGE_SCREEN_ID', true);
            $table->integer('DISTRIBUTOR_MANAGE_SUBMODULE_ID')->nullable();
            $table->integer('DISTRIBUTOR_MODULE_ID')->nullable();
            $table->string('DISTRIBUTOR_SCREEN_NAME', 100)->nullable();
            $table->string('DISTRIBUTOR_SCREEN_ROUTE', 100)->nullable();
            $table->integer('DISTRIBUTOR_SCREEN_PROCESS_ID')->nullable();
            $table->string('DISTRIBUTOR_SCREEN_DESC', 100)->nullable();
            $table->string('DISTRIBUTOR_SCREEN_CODE', 192)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DISTRIBUTOR_MANAGE_SCREEN');
    }
}
