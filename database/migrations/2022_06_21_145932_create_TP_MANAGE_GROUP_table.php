<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPMANAGEGROUPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TP_MANAGE_GROUP', function (Blueprint $table) {
            $table->integer('TP_MANAGE_GROUP_ID', true);
            $table->string('TP_MANAGE_GROUP_NAME', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TP_MANAGE_GROUP');
    }
}
