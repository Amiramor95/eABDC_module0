<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPMANAGEMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TP_MANAGE_MODULE', function (Blueprint $table) {
            $table->integer('TP_MANAGE_MODULE_ID', true);
            $table->string('TP_MOD_NAME', 100)->nullable();
            $table->string('TP_MOD_SNAME', 100)->nullable();
            $table->string('TP_MOD_CODE', 100)->nullable();
            $table->integer('TP_MOD_INDEX')->nullable();
            $table->string('TP_MOD_ICON', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TP_MANAGE_MODULE');
    }
}
