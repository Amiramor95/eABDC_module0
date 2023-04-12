<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCPDHOURSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CPD_HOURS', function (Blueprint $table) {
            $table->integer('CPD_HOURS_ID', true);
            $table->integer('CPD_PROGRAM_TYPE')->nullable();
            $table->string('CPD_PROGRAM_NAME', 100);
            $table->string('CPD_CODE', 4)->nullable();
            $table->integer('FP_CATEGORY')->nullable();
            $table->integer('CPD_MIN');
            $table->integer('CPD_MAX');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CPD_HOURS');
    }
}
