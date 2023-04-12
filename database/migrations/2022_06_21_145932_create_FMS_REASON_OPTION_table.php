<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFMSREASONOPTIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FMS_REASON_OPTION', function (Blueprint $table) {
            $table->integer('FMS_REASON_OPTION_ID', true);
            $table->string('FMS_REASON_OPTION_NAME', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FMS_REASON_OPTION');
    }
}
