<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateANNUALFEESDATETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ANNUAL_FEES_DATE', function (Blueprint $table) {
            $table->integer('ANNUAL_FEES_DATE_ID', true);
            $table->year('ASSESSMENT_YEAR')->nullable();
            $table->date('ASSESSMENT_START_DATE')->nullable();
            $table->date('ASSESSMENT_END_DATE')->nullable();
            $table->date('SUBMISSION_START_DATE')->nullable();
            $table->date('SUBMISSION_END_DATE')->nullable();
            $table->integer('RNA_VERIFICATION_PERIOD_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ANNUAL_FEES_DATE');
    }
}
