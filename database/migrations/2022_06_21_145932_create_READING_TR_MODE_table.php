<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateREADINGTRMODETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('READING_TR_MODE', function (Blueprint $table) {
            $table->integer('READING_TR_MODE_ID', true);
            $table->string('READING_TR_MODE_NAME', 25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('READING_TR_MODE');
    }
}
