<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORMANAGEGROUPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_MANAGE_GROUP', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_MANAGE_GROUP_ID', true);
            $table->string('DISTRIBUTOR_MANAGE_GROUP_NAME', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DISTRIBUTOR_MANAGE_GROUP');
    }
}
