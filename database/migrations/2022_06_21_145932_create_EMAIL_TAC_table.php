<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEMAILTACTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EMAIL_TAC', function (Blueprint $table) {
            $table->integer('EMAIL_TAC_ID', true);
            $table->integer('EMAIL_TAC_NUMBER');
            $table->string('EMAIL_TAC_RECIPIENT', 50);
            $table->string('EMAIL_TAC_END_TIME', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('EMAIL_TAC');
    }
}
