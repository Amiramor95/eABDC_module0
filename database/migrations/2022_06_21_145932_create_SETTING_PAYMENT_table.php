<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGPAYMENTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_PAYMENT', function (Blueprint $table) {
            $table->integer('SETTING_PAYMENT_ID', true);
            $table->string('PAY_BANK_NAME', 100);
            $table->string('PAY_TRAN_TYPE', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_PAYMENT');
    }
}
