<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTMANAGEGROUPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_MANAGE_GROUP', function (Blueprint $table) {
            $table->integer('CONSULTANT_MANAGE_GROUP_ID', true);
            $table->string('CONSULTANT_GROUP_NAME', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_MANAGE_GROUP');
    }
}
