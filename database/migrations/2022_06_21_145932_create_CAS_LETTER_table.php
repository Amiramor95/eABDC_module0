<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCASLETTERTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CAS_LETTER', function (Blueprint $table) {
            $table->integer('CAS_LETTER_ID', true);
            $table->string('CAS_LETTER_TITTLE', 100)->nullable();
            $table->longText('CAS_LETTER_DESC')->nullable();
            $table->integer('CREATE_BY')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CAS_LETTER');
    }
}
