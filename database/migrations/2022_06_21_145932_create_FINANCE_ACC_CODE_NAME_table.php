<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFINANCEACCCODENAMETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FINANCE_ACC_CODE_NAME', function (Blueprint $table) {
            $table->integer('FINANCE_ACC_CODE_NAME_ID', true);
            $table->string('PROCESS', 200);
            $table->string('ACCOUNT_NAME', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FINANCE_ACC_CODE_NAME');
    }
}
