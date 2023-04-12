<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePENDINGTASKTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PENDING_TASK', function (Blueprint $table) {
            $table->integer('PENDING_TASK_ID', true);
            $table->string('PENDING_TASK_NAME', 200);
            $table->string('PENDING_TASK_ROUTE', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PENDING_TASK');
    }
}
