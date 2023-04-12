<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRPROGRAMTYPETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TR_PROGRAM_TYPE', function (Blueprint $table) {
            $table->integer('TR_PROGRAM_TYPE_ID', true);
            $table->string('TR_PROGRAM_TYPE_NAME', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TR_PROGRAM_TYPE');
    }
}
