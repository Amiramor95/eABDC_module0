<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCPDRENEWALCALCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CPD_RENEWAL_CALC', function (Blueprint $table) {
            $table->integer('CPD_RENEWAL_CALC_ID', true);
            $table->integer('RENEWAL_MONTH');
            $table->date('EFFECTIVE_DATE')->nullable();
            $table->integer('EFFECTIVE_YEAR');
            $table->decimal('RENEWAL_CALC', 19);
            $table->integer('RENEWAL_REQUIREMENT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CPD_RENEWAL_CALC');
    }
}
