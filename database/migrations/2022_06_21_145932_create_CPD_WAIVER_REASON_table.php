<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCPDWAIVERREASONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CPD_WAIVER_REASON', function (Blueprint $table) {
            $table->integer('WAIVER_REASON_ID', true);
            $table->string('WAIVER_REASON', 1500)->nullable();
            $table->tinyInteger('ISENABLED')->default(0)->comment('0:ENABLED, 1:DISABLED');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CPD_WAIVER_REASON');
    }
}
