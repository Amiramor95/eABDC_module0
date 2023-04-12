<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTFEETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_FEE', function (Blueprint $table) {
            $table->integer('CONSULTANT_FEE_ID', true);
            $table->integer('CONSULTANT_FEE_TYPE_ID')->comment('SETTING_GENERAL - type - FEETYPE');
            $table->integer('CONSULTANT_TYPE_ID')->nullable();
            $table->integer('EXAM_TYPE_ID')->nullable();
            $table->double('EXAM_FEE', 18, 2)->nullable();
            $table->double('ANNUAL_FEE', 18, 2);
            $table->double('PROCESSING_FEE', 18, 2)->nullable();
            $table->double('VARIATION_FEE', 18, 2)->nullable();
            $table->double('AUTHORISATION_CARD_FEE', 18, 2)->nullable();
            $table->double('TOTAL_FEE', 18, 2)->nullable();
            $table->double('TAX_FEE', 18, 2)->nullable();
            $table->double('TOTAL_AMOUNT_FEE', 18, 2)->nullable();
            $table->date('CONS_EFFECTIVE_DATE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_FEE');
    }
}
