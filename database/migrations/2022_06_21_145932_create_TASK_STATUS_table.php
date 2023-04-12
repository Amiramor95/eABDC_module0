<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTASKSTATUSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TASK_STATUS', function (Blueprint $table) {
            $table->integer('TS_ID', true);
            $table->string('TS_PARAM', 250)->nullable();
            $table->string('TS_CODE', 50)->nullable();
            $table->string('TS_REMARK', 250)->nullable();
            $table->string('TS_DESCRIPTION', 250)->nullable();
            $table->tinyInteger('TS_INDEX')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TASK_STATUS');
    }
}
