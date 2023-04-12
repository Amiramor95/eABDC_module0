<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORSCREENACCESSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_SCREEN_ACCESS', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_SCREEN_ACCESS_ID', true);
            $table->integer('DISTRIBUTOR_MANAGE_GROUP_ID')->nullable();
            $table->string('DISTRIBUTOR_SCREEN_ID', 1000)->nullable();
            $table->integer('DISTRIBUTOR_AUTHORISATION_ID')->nullable();
            $table->integer('DISTRIBUTOR_USER_ID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DISTRIBUTOR_SCREEN_ACCESS');
    }
}
