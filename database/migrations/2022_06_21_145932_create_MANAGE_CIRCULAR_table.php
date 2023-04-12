<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGECIRCULARTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_CIRCULAR', function (Blueprint $table) {
            $table->integer('MANAGE_CIRCULAR_ID', true);
            $table->integer('MANAGE_DEPARTMENT_ID')->nullable()->comment('REFER TO TABLE MANAGE_DEPARTMENT');
            $table->tinyInteger('CIRCULAR_STATUS')->default(0)->comment('1: ON, 0 :OFF');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_CIRCULAR');
    }
}
