<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateADDITIONALUSERACCESSSCREENTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ADDITIONAL_USER_ACCESS_SCREEN', function (Blueprint $table) {
            $table->integer('ADDITIONAL_USER_ACCESS_SCREEN_ID', true);
            $table->integer('USER_ID');
            $table->integer('SCREEN_ACCESS_ID');
            $table->string('ADDITIONAL_SCREEN_ID', 192);
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
        Schema::dropIfExists('ADDITIONAL_USER_ACCESS_SCREEN');
    }
}
