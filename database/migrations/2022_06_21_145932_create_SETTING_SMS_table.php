<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_SMS', function (Blueprint $table) {
            $table->integer('SETTING_SMS_ID', true);
            $table->string('SMS_HTTP_URL', 100)->nullable();
            $table->string('SMS_HTTP_PARAM', 100)->nullable();
            $table->string('SMS_REQ_HEADER', 100)->nullable();
            $table->string('SMS_RES_SUCCESS', 100)->nullable();
            $table->string('SMS_RES_FAILURE', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_SMS');
    }
}
