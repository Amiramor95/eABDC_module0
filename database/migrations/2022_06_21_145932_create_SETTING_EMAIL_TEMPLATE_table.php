<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGEMAILTEMPLATETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_EMAIL_TEMPLATE', function (Blueprint $table) {
            $table->integer('EMAIL_TEMPLATE_ID', true);
            $table->string('EMAIL_TEMP_TITLE', 500)->nullable();
            $table->string('EMAIL_TEMP_BODY', 1000);
            $table->integer('EMAIL_TEMP_TYPE');
            $table->string('EMAIL_TEMP_DESCRIPTION', 500)->nullable();
            $table->integer('CREATE_BY')->index('CREATE_BY');
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
        Schema::dropIfExists('SETTING_EMAIL_TEMPLATE');
    }
}
