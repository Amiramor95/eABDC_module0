<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTTYPEOFAPPLICATIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_TYPE_OF_APPLICATION', function (Blueprint $table) {
            $table->integer('TYPE_OF_APPLICATION_ID', true);
            $table->string('TYPE_OF_APPLICATION_NAME', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_TYPE_OF_APPLICATION');
    }
}
