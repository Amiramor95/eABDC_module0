<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTEXAMTYPETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_EXAM_TYPE', function (Blueprint $table) {
            $table->integer('CONSULTANT_EXAM_TYPE_ID', true);
            $table->integer('CONSULTANT_TYPE_ID');
            $table->string('EXAM_TYPE_NAME', 50);
            $table->string('EXAM_TYPE_DESC', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_EXAM_TYPE');
    }
}
