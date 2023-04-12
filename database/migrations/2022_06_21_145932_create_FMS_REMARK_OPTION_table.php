<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFMSREMARKOPTIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FMS_REMARK_OPTION', function (Blueprint $table) {
            $table->integer('FMS_REMARK_OPTION_ID', true);
            $table->string('FMS_REMARK_OPTION_NAME', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FMS_REMARK_OPTION');
    }
}
