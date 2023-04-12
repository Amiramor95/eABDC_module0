<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFMSCUTOFFTIMETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FMS_CUTOFF_TIME', function (Blueprint $table) {
            $table->integer('FMS_CUTOFF_TIME_ID', true);
            $table->time('NAV_LOCAL_START_TIME');
            $table->time('NAV_LOCAL_END_TIME');
            $table->time('NAV_FOREIGN_START_TIME');
            $table->time('NAV_FOREIGN_END_TIME');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FMS_CUTOFF_TIME');
    }
}
