<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORMANAGEMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_MANAGE_MODULE', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_MANAGE_MODULE_ID', true);
            $table->string('DISTRIBUTOR_MOD_CODE', 100);
            $table->string('DISTRIBUTOR_MOD_NAME', 100);
            $table->string('DISTRIBUTOR_MOD_SNAME', 100);
            $table->string('DISTRIBUTOR_MOD_INDEX', 100);
            $table->string('DISTRIBUTOR_MOD_ICON', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DISTRIBUTOR_MANAGE_MODULE');
    }
}
