<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGESUBMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_SUBMODULE', function (Blueprint $table) {
            $table->integer('MANAGE_SUBMODULE_ID', true);
            $table->integer('MANAGE_MODULE_ID')->index('MOD_ID');
            $table->string('SUBMOD_CODE', 10);
            $table->string('SUBMOD_NAME', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_SUBMODULE');
    }
}
