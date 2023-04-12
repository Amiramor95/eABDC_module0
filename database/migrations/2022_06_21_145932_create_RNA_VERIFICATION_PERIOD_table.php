<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRNAVERIFICATIONPERIODTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RNA_VERIFICATION_PERIOD', function (Blueprint $table) {
            $table->integer('RNA_VERIFICATION_PERIOD_ID', true);
            $table->date('RNA_START_DATE')->nullable();
            $table->date('RNA_END_DATE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('RNA_VERIFICATION_PERIOD');
    }
}
