<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSTACTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SMS_TAC', function (Blueprint $table) {
            $table->integer('SMS_TAC_ID', true);
            $table->integer('SMS_TAC_NUMBER');
            $table->string('SMS_TAC_RECIPIENT', 50);
            $table->string('SMS_TAC_END_TIME', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SMS_TAC');
    }
}
