<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTMANAGEMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_MANAGE_MODULE', function (Blueprint $table) {
            $table->integer('CONSULTANT_MANAGE_MODULE_ID', true);
            $table->string('CONSULTANT_MOD_CODE', 100);
            $table->string('CONSULTANT_MOD_NAME', 100);
            $table->string('CONSULTANT_MOD_SNAME', 100);
            $table->integer('CONSULTANT_MOD_INDEX');
            $table->string('CONSULTANT_MOD_ICON', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_MANAGE_MODULE');
    }
}
