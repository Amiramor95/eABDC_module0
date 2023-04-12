<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFINANCEFEEAMOUNTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FINANCE_FEE_AMOUNT', function (Blueprint $table) {
            $table->integer('FINANCE_FEE_AMOUNT_ID', true);
            $table->integer('FEE_CLASSIFICATION');
            $table->date('FEE_DATE');
            $table->string('FEE_TYPE', 50);
            $table->double('FEE_AMOUNT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FINANCE_FEE_AMOUNT');
    }
}
