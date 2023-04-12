<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSYSTEMBLOCKDURATIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SYSTEM_BLOCK_DURATION', function (Blueprint $table) {
            $table->integer('SYSTEM_BLOCK_DURATION_ID', true);
            $table->integer('SYSTEM_BLOCK_DURATION_DAYS');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SYSTEM_BLOCK_DURATION');
    }
}
