<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCPDSETTINGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CPD_SETTING', function (Blueprint $table) {
            $table->integer('CPD_SETTING_ID', true);
            $table->string('CPD_SETTING_TYPE', 50)->nullable();
            $table->string('CPD_SETTING_NAME', 50)->nullable();
            $table->string('CPD_SETTING_MODE', 50)->nullable();
            $table->integer('CPD_SETTING_INDEX')->nullable();
            $table->string('CPD_SETTING_DESCRIPTION')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CPD_SETTING');
    }
}
