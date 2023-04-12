<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLSASSESSMENTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LS_ASSESSMENT', function (Blueprint $table) {
            $table->integer('LS_ASSESSMENT_ID', true);
            $table->string('LS_ASSESSMENT_NAME', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LS_ASSESSMENT');
    }
}
