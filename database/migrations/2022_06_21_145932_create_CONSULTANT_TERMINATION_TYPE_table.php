<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTTERMINATIONTYPETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_TERMINATION_TYPE', function (Blueprint $table) {
            $table->integer('CONSULTANT_TERMINATION_TYPE_ID', true);
            $table->string('TERMINATION_TYPE_STATUS');
            $table->string('TERMINATION_TYPE_REASON');
            $table->string('TERMINATION_TYPE_DESCRIPTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_TERMINATION_TYPE');
    }
}
