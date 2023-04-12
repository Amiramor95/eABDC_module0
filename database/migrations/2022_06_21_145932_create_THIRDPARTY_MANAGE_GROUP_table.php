<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTHIRDPARTYMANAGEGROUPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('THIRDPARTY_MANAGE_GROUP', function (Blueprint $table) {
            $table->integer('THIRDPARTY_MANAGE_GROUP_ID', true);
            $table->string('THIRDPARTY_GROUP_NAME', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('THIRDPARTY_MANAGE_GROUP');
    }
}
