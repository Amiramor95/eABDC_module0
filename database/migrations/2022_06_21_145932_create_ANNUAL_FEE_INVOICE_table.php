<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateANNUALFEEINVOICETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ANNUAL_FEE_INVOICE', function (Blueprint $table) {
            $table->integer('ANNUAL_FEE_INVOICE_ID', true);
            $table->string('ANNUAL_FEE_PREFIX', 15)->nullable();
            $table->integer('ANNUAL_FEE_NUMBER')->nullable();
            $table->integer('ANNUAL_FEE_CURR_NUMBER');
            $table->year('ANNUAL_FEE_YEAR')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ANNUAL_FEE_INVOICE');
    }
}
