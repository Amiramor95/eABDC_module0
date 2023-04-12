<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCPDCUTOFFDATETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CPD_CUT_OFF_DATE', function (Blueprint $table) {
            $table->integer('CPD_CUT_OFF_DATE_ID', true);
            $table->date('CPD_CUT_OFF_DATE');
            $table->date('CPD_CUT_OFF_END_DATE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CPD_CUT_OFF_DATE');
    }
}
