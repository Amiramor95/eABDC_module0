<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGEDISTRIBUTORGROUPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_DISTRIBUTOR_GROUP', function (Blueprint $table) {
            $table->integer('MANAGE_DISTRIBUTOR_GROUP_ID', true);
            $table->string('GROUP_NAME', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_DISTRIBUTOR_GROUP');
    }
}
