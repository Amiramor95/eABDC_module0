<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGEDEPARTMENTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_DEPARTMENT', function (Blueprint $table) {
            $table->integer('MANAGE_DEPARTMENT_ID', true);
            $table->integer('MANAGE_DIVISION_ID')->nullable();
            $table->string('DPMT_NAME', 200)->nullable();
            $table->string('DPMT_SNAME', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_DEPARTMENT');
    }
}
