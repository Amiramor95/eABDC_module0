<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGCITYTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_CITY', function (Blueprint $table) {
            $table->integer('SETTING_CITY_ID', true);
            $table->string('SET_CITY_NAME', 100)->nullable();
            $table->integer('SETTING_GENERAL_ID')->nullable();
            $table->string('CITY_CREATE_BY', 50)->nullable();
            $table->timestamp('CITY_CREATE_TIMESTAMP')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_CITY');
    }
}
