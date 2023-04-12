<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFIVEMODULETRMODETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FIVE_MODULE_TR_MODE', function (Blueprint $table) {
            $table->integer('FIVE_MODULE_TR_MODE_ID', true);
            $table->string('FIVE_MODULE_TR_MODE_NAME', 25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FIVE_MODULE_TR_MODE');
    }
}
