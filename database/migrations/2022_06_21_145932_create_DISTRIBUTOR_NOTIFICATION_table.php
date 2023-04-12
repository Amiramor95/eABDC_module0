<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORNOTIFICATIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_NOTIFICATION', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_NOTIFICATION_ID', true);
            $table->integer('NOTIFICATION_GROUP_ID');
            $table->integer('DISTRIBUTOR_ID');
            $table->integer('PROCESS_FLOW_ID');
            $table->integer('NOTIFICATION_STATUS')->default(0);
            $table->string('REMARK', 500)->nullable();
            $table->timestamp('NOTIFICATION_DATE')->useCurrentOnUpdate()->useCurrent();
            $table->string('LOCATION', 350);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DISTRIBUTOR_NOTIFICATION');
    }
}
