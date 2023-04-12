<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORFEETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_FEE', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_FEE_ID', true);
            $table->integer('DIST_TYPE_ID')->nullable();
            $table->double('APPLICATION_FEE', 18, 2)->nullable();
            $table->double('TAX_APPLICATION_FEE', 18, 2)->nullable();
            $table->double('TOTAL_AMOUNT_APPLICATION', 18, 2)->nullable();
            $table->double('ANNUAL_FEE', 18, 2)->nullable();
            $table->double('TAX_ANNUAL_FEE', 18, 2)->nullable();
            $table->double('TOTAL_AMOUNT_ANNUAL_FEE', 18, 2)->nullable();
            $table->date('FEE_START_DATE')->nullable();
            $table->date('FEE_END_DATE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DISTRIBUTOR_FEE');
    }
}
