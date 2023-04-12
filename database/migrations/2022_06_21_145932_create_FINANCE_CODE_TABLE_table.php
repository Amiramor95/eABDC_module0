<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFINANCECODETABLETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FINANCE_CODE_TABLE', function (Blueprint $table) {
            $table->integer('FINANCE_CODE_TABLE_ID', true);
            $table->integer('CODE_NUMBER');
            $table->string('CODE_TYPE', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FINANCE_CODE_TABLE');
    }
}
