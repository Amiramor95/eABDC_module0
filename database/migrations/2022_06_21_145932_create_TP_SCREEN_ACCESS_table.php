<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPSCREENACCESSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TP_SCREEN_ACCESS', function (Blueprint $table) {
            $table->integer('TP_SCREEN_ACCESS_ID', true);
            $table->integer('TP_MANAGE_GROUP_ID')->nullable();
            $table->integer('TP_AUTHORISATION_ID')->nullable();
            $table->string('TP_MANAGE_SCREEN_ID', 100)->nullable();
            $table->integer('TP_USER_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TP_SCREEN_ACCESS');
    }
}
