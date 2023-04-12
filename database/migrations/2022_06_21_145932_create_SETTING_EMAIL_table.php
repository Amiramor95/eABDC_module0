<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGEMAILTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_EMAIL', function (Blueprint $table) {
            $table->integer('SETTING_EMAIL_ID', true);
            $table->string('EMAIL_FROM', 100)->nullable();
            $table->string('NOTIFICATION_TO', 200)->nullable();
            $table->string('EMAIL_SECURITY', 11)->nullable();
            $table->string('EMAIL_SMTP_SERVER', 100)->nullable();
            $table->integer('EMAIL_SMTP_PORT')->nullable();
            $table->string('EMAIL_LOGIN_ID', 100)->nullable();
            $table->string('EMAIL_LOGIN_PASS', 100)->nullable();
            $table->string('EMAIL_LOGIN_PASS_VER1')->nullable();
            $table->integer('EMAIL_LOGIN_PASS_VER2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_EMAIL');
    }
}
