<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTAPPEALEXAMINATIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_APPEAL_EXAMINATION', function (Blueprint $table) {
            $table->integer('CONSULTANT_APPEAL_EXAMINATION_ID', true);
            $table->integer('EXAM_APPEAL_DAY');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_APPEAL_EXAMINATION');
    }
}
