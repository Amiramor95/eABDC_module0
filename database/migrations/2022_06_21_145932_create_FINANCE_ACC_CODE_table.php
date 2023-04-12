<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFINANCEACCCODETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FINANCE_ACC_CODE', function (Blueprint $table) {
            $table->integer('FINANCE_ACC_CODE_ID', true);
            $table->string('ACC_CODE', 10);
            $table->string('REF_NUMBER', 10);
            $table->integer('FINANCE_ACC_CODE_TYPE_ID');
            $table->string('FINANCE_ACC_CODE_NAME', 100);
            $table->integer('STATUS')->comment('0-inactive 1-active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FINANCE_ACC_CODE');
    }
}
