<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTHIRDPARTYSUBMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('THIRDPARTY_SUBMODULE', function (Blueprint $table) {
            $table->integer('THIRDPARTY_SUBMODULE_ID', true);
            $table->string('THIRDPARTY_SUBMOD_CODE', 100)->nullable();
            $table->string('THIRDPARTY_SUBMOD_NAME', 100)->nullable();
            $table->integer('THIRDPARTY_MANAGE_MODULE_ID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('THIRDPARTY_SUBMODULE');
    }
}
