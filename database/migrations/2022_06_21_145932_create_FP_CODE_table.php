<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFPCODETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FP_CODE', function (Blueprint $table) {
            $table->integer('FP_CODE_ID', true);
            $table->string('FP_CODE_NAME', 35);
            $table->string('FP_CODE_DESCRIPTION', 40);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FP_CODE');
    }
}
