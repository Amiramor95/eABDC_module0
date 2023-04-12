<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGPASSWORDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_PASSWORD', function (Blueprint $table) {
            $table->integer('MIN_LENGTH')->nullable();
            $table->integer('MAX_LENGTH')->nullable();
            $table->boolean('UPPERCASE_LOWERCASE');
            $table->boolean('ALPHANUMERIC');
            $table->boolean('SPECIAL_CHARACTERS');
            $table->integer('SETTING_PASSWORD_ID', true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_PASSWORD');
    }
}
