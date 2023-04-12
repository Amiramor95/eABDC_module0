<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateANNUALFEECUTOFFTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ANNUALFEE_CUTOFF', function (Blueprint $table) {
            $table->integer('ANNUALFEE_CUTOFF_ID', true);
            $table->date('CUTOFF_DATE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ANNUALFEE_CUTOFF');
    }
}
