<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWAIVERFEETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('WAIVER_FEE', function (Blueprint $table) {
            $table->integer('WAIVER_FEE_ID', true);
            $table->integer('WAIVER_FEE_TYPE_ID')->nullable()->comment('SETTING_GENERAL - type - FEETYPE');
            $table->integer('WAIVER_TYPE_ID')->nullable();
            $table->integer('CONSULTANT_TYPE_ID')->nullable();
            $table->integer('EXAM_TYPE_ID')->nullable();
            $table->double('EXAM_FEE', 18, 2)->nullable();
            $table->double('ANNUAL_FEE', 18, 2)->nullable();
            $table->double('PROCESSING_FEE', 18, 2)->nullable();
            $table->double('VARIATION_FEE', 18, 2)->nullable();
            $table->double('AUTHORISATION_CARD_FEE', 18, 2)->nullable();
            $table->double('TOTAL_FEE', 18, 2)->nullable();
            $table->double('TAX_FEE', 18, 2)->nullable();
            $table->double('TOTAL_AMOUNT_FEE', 18, 2)->nullable();
            $table->date('WAIVER_START_DATE')->nullable();
            $table->date('WAIVER_END_DATE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('WAIVER_FEE');
    }
}
