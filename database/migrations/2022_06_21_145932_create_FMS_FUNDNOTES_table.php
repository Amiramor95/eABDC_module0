<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFMSFUNDNOTESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FMS_FUNDNOTES', function (Blueprint $table) {
            $table->integer('FUNDNOTES_ID', true);
            $table->string('FUNDNOTES_DESC');
            $table->string('FUND_NOTES_DENOTATION', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FMS_FUNDNOTES');
    }
}
