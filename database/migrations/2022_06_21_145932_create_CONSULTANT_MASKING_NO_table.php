<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTMASKINGNOTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_MASKING_NO', function (Blueprint $table) {
            $table->integer('CONSULTANT_MASKING_ID', true);
            $table->string('PREFIX', 10);
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
        Schema::dropIfExists('CONSULTANT_MASKING_NO');
    }
}
