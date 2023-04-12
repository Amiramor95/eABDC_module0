<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNOTIFICATIONTYPETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('NOTIFICATION_TYPE', function (Blueprint $table) {
            $table->integer('NOTIFICATION_TYPE_ID', true);
            $table->string('NOTIFICATION_TYPE', 50);
            $table->string('NOTIFICATION_TEMPLATE', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('NOTIFICATION_TYPE');
    }
}
