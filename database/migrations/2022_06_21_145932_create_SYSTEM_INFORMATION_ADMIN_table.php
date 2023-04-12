<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSYSTEMINFORMATIONADMINTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SYSTEM_INFORMATION_ADMIN', function (Blueprint $table) {
            $table->integer('SYSTEM_INFORMATION_ID', true);
            $table->string('SYSTEM_MAIN_LABEL');
            $table->string('SYSTEM_SUB_LABEL');
            $table->string('PARAM_VALUE', 200);
            $table->timestamp('CREATE_TIMESTAMP')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SYSTEM_INFORMATION_ADMIN');
    }
}
