<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGGENERALTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_GENERAL', function (Blueprint $table) {
            $table->integer('SETTING_GENERAL_ID', true);
            $table->string('SET_TYPE', 20)->nullable();
            $table->string('SET_CODE', 100)->nullable();
            $table->string('SET_PARAM', 500)->nullable();
            $table->string('SET_VALUE', 20)->nullable();
            $table->integer('SET_SUB_VALUE')->nullable();
            $table->integer('SET_INDEX')->nullable();
            $table->string('SET_DESCRIPTION', 500)->nullable();
            $table->string('SET_REMARK', 150)->nullable();
            $table->integer('SET_CREATE_BY')->nullable()->index('SET_CREATE_BY');
            $table->timestamp('SET_CREATE_TIMESTAMP')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_GENERAL');
    }
}
