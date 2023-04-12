<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePURGEDATAPERIODTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PURGE_DATA_PERIOD', function (Blueprint $table) {
            $table->integer('PURGE_DATA_ID', true);
            $table->decimal('DIST_DURATION', 20, 0)->default(0);
            $table->decimal('CONST_DURATION', 20, 0)->default(0);
            $table->decimal('THIRD_DURATION', 20, 0)->default(0);
            $table->decimal('TP_DURATION', 20, 0)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PURGE_DATA_PERIOD');
    }
}
