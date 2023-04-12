<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUSERROLEMATRIXTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('USER_ROLE_MATRIX', function (Blueprint $table) {
            $table->integer('ROLE_MATRIX_ID', true);
            $table->integer('USER_ID');
            $table->string('SCREEN_ID', 192);
            $table->integer('GROUP_ID');
            $table->integer('AUTHORIZATION_LEVEL_ID');
            $table->integer('CREATE_BY');
            $table->timestamp('CREATE_AT')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('USER_ROLE_MATRIX');
    }
}
