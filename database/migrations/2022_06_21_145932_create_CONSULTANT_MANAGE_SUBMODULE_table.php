<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTMANAGESUBMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_MANAGE_SUBMODULE', function (Blueprint $table) {
            $table->integer('CONSULTANT_MANAGE_SUBMODULE_ID', true);
            $table->string('CONSULTANT_SUBMODULE_CODE', 100);
            $table->string('CONSULTANT_SUBMODULE_NAME', 100);
            $table->integer('CONSULTANT_MODULE_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_MANAGE_SUBMODULE');
    }
}
