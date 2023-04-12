<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGUSERIDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_USERID', function (Blueprint $table) {
            $table->integer('MIN_LENGTH')->default(0);
            $table->integer('MAX_LENGTH')->nullable()->default(0);
            $table->boolean('UPPERCASE_LOWERCASE');
            $table->boolean('ALPHANUMERIC');
            $table->boolean('SPECIAL_CHARACTERS');
            $table->integer('SETTING_USERID_ID', true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_USERID');
    }
}
