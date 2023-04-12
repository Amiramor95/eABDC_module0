<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGEMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_MODULE', function (Blueprint $table) {
            $table->integer('MANAGE_MODULE_ID', true);
            $table->string('MOD_CODE', 10)->nullable();
            $table->string('MOD_NAME', 100)->nullable();
            $table->string('MOD_SNAME', 50)->nullable();
            $table->integer('MOD_INDEX')->nullable()->default(0);
            $table->string('MOD_ICON', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_MODULE');
    }
}
