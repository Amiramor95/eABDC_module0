<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFINANCEACCCODETYPETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FINANCE_ACC_CODE_TYPE', function (Blueprint $table) {
            $table->integer('FINANCE_ACC_CODE_TYPE_ID', true);
            $table->string('CODE_TYPE', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FINANCE_ACC_CODE_TYPE');
    }
}
