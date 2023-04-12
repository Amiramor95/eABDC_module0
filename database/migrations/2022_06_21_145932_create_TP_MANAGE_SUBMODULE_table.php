<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPMANAGESUBMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TP_MANAGE_SUBMODULE', function (Blueprint $table) {
            $table->integer('TP_MANAGE_SUBMODULE_ID', true);
            $table->integer('TP_MANAGE_MODULE_ID')->nullable();
            $table->string('TP_SUBMOD_CODE', 100)->nullable();
            $table->string('TP_SUBMOD_NAME', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TP_MANAGE_SUBMODULE');
    }
}
