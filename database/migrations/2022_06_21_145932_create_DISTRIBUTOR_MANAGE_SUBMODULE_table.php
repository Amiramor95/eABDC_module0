<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORMANAGESUBMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_MANAGE_SUBMODULE', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_MANAGE_SUBMODULE_ID', true);
            $table->string('DISTRIBUTOR_SUBMODULE_CODE', 100);
            $table->string('DISTRIBUTOR_SUBMODULE_NAME', 100);
            $table->integer('DISTRIBUTOR_MODULE_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DISTRIBUTOR_MANAGE_SUBMODULE');
    }
}
