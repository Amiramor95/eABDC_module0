<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGEANNOUNCEMENTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_ANNOUNCEMENT', function (Blueprint $table) {
            $table->integer('MANAGE_ANNOUNCEMENT_ID', true);
            $table->integer('MANAGE_DEPARTMENT_ID')->nullable()->index('MANAGE_DEPARTMENT_ID');
            $table->tinyInteger('ANNOUNCEMENT_STATUS')->nullable()->comment('0: Off, 1: On');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_ANNOUNCEMENT');
    }
}
