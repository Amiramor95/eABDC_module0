<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTNOTIFICATIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_NOTIFICATION', function (Blueprint $table) {
            $table->integer('CONSULTANT_NOTIFICATION_ID', true);
            $table->integer('NOTIFICATION_GROUP_ID')->nullable();
            $table->integer('CONSULTANT_ID')->nullable();
            $table->integer('PROCESS_FLOW_ID')->nullable();
            $table->integer('NOTIFICATION_STATUS')->nullable();
            $table->string('REMARK', 500)->nullable();
            $table->timestamp('NOTIFICATION_DATE')->nullable();
            $table->string('LOCATION', 350)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_NOTIFICATION');
    }
}
