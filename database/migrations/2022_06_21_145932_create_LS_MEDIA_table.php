<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLSMEDIATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LS_MEDIA', function (Blueprint $table) {
            $table->integer('LS_MEDIA_ID', true);
            $table->string('LS_MEDIA_NAME', 25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LS_MEDIA');
    }
}
