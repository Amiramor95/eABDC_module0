<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGSMSTEMPLATETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_SMS_TEMPLATE', function (Blueprint $table) {
            $table->integer('SETTING_SMS_TEMPLATE_ID', true);
            $table->integer('SETTING_SMS_ID')->index('SMS_ID');
            $table->string('SMS_TEMP_NAME', 500);
            $table->string('SMS_TEMP_TITLE', 500);
            $table->string('SMS_TEMP_BODY', 500);
            $table->integer('SMS_TEMP_TYPE');
            $table->string('SMS_TEMP_DESCRIPTION', 500);
            $table->integer('CREATE_BY');
            $table->timestamp('CREATE_TIMESTAMP')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_SMS_TEMPLATE');
    }
}
