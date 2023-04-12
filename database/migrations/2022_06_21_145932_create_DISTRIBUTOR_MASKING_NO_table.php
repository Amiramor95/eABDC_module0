<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORMASKINGNOTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_MASKING_NO', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_MASKING_ID', true);
            $table->integer('START_NUMBER');
            $table->integer('CURRENT_NUMBER');
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
        Schema::dropIfExists('DISTRIBUTOR_MASKING_NO');
    }
}
