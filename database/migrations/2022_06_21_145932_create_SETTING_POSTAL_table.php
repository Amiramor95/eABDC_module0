<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGPOSTALTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_POSTAL', function (Blueprint $table) {
            $table->integer('SETTING_POSTCODE_ID', true);
            $table->string('POSTCODE_NO', 10);
            $table->integer('SETTING_CITY_ID')->index('SETTING_CITY_ID');
            $table->string('POSTCODE_CREATE_BY', 100)->nullable();
            $table->timestamp('POSTCODE_CREATE_TIMESTAMP')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_POSTAL');
    }
}
