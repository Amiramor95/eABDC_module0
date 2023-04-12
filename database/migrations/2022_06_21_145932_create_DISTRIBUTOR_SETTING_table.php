<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORSETTINGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_SETTING', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_SETTING_ID', true);
            $table->string('DIST_SET_TYPE', 100)->nullable();
            $table->string('DIST_SET_CODE', 100)->nullable();
            $table->string('DIST_SET_PARAM', 500)->nullable();
            $table->string('DIST_SET_VALUE', 20)->nullable();
            $table->integer('DIST_SET_INDEX')->nullable();
            $table->string('DIST_SET_DESCRIPTION', 500)->nullable();
            $table->string('DIST_SET_REMARK', 150)->nullable();
            $table->integer('DIST_CREATE_BY')->nullable();
            $table->timestamp('DIST_CREATE_TIMESTAMP')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DISTRIBUTOR_SETTING');
    }
}
