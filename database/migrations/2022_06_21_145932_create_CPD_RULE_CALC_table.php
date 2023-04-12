<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCPDRULECALCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CPD_RULE_CALC', function (Blueprint $table) {
            $table->integer('CPD_RULE_CALC_ID', true);
            $table->string('CPD_RULE_TYPE', 50)->nullable();
            $table->string('CPD_RULE_CONDITION')->nullable();
            $table->integer('CPD_RULE_POINT')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CPD_RULE_CALC');
    }
}
