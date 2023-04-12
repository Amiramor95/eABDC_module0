<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTACTIVECEILLILICENSETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_ACTIVE_CEILLI_LICENSE', function (Blueprint $table) {
            $table->integer('CONSULTANT_ACTIVE_CEILLI_LICENSE_ID', true);
            $table->date('ACTIVE_CEILLI_START_DATE');
            $table->date('ACTIVE_CEILLI_END_DATE');
            $table->date('ACTIVE_CEILLI_EFFECTIVE_DATE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_ACTIVE_CEILLI_LICENSE');
    }
}
