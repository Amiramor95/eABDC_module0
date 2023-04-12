<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePROCESSFLOWTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PROCESS_FLOW', function (Blueprint $table) {
            $table->integer('PROCESS_FLOW_ID', true);
            $table->string('PROCESS_FLOW_NAME');
            $table->string('MODULE_ID');
            $table->integer('PF_INDEX')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PROCESS_FLOW');
    }
}
