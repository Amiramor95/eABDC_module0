<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTHIRDPARTYMANAGEMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('THIRDPARTY_MANAGE_MODULE', function (Blueprint $table) {
            $table->integer('THIRDPARTY_MANAGE_MODULE_ID', true);
            $table->string('THIRDPARTY_MOD_NAME', 100)->nullable();
            $table->string('THIRDPARTY_MOD_SNAME', 100)->nullable();
            $table->integer('THIRDPARTY_MOD_INDEX')->nullable();
            $table->string('THIRDPARTY_MOD_CODE', 50)->nullable();
            $table->string('THIRDPARTY_MOD_ICON', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('THIRDPARTY_MANAGE_MODULE');
    }
}
