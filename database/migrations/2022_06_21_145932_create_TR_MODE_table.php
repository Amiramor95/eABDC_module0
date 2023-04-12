<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRMODETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TR_MODE', function (Blueprint $table) {
            $table->integer('TR_MODE_ID', true);
            $table->string('TR_MODE_NAME', 25);
            $table->integer('MIN_POINT')->nullable()->default(0);
            $table->integer('MAX_POINT')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TR_MODE');
    }
}
