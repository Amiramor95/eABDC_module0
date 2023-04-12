<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNOTIFICATIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('NOTIFICATION', function (Blueprint $table) {
            $table->integer('NOTIFICATION_ID', true);
            $table->integer('NOTIFICATION_GROUP_ID')->comment('AM - USER (USER_GROUP)');
            $table->integer('PROCESS_FLOW_ID');
            $table->integer('NOTIFICATION_STATUS')->default(0);
            $table->string('REMARK', 500)->nullable()->default('There is item to be reviewed');
            $table->timestamp('NOTIFICATION_DATE')->useCurrent();
            $table->string('LOCATION', 350)->nullable();
            $table->integer('REFERENCE_ID')->nullable()->comment('USE FOR CAS EMAIL NOTIFICATION(CA_DETAILS_RECORD_ID)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('NOTIFICATION');
    }
}
