<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTEXAMSESSIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_EXAM_SESSION', function (Blueprint $table) {
            $table->integer('CONSULTANT_EXAM_SESSION_ID', true);
            $table->integer('EXAM_SESSION_DAYS');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_EXAM_SESSION');
    }
}
