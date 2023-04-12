<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSLOGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SMS_LOG', function (Blueprint $table) {
            $table->integer('SMS_LOG_ID', true);
            $table->string('SMS_MESSAGE_ID', 50);
            $table->string('SMS_RECIPIENT', 15);
            $table->text('MESSAGE');
            $table->tinyInteger('SMS_STATUS')->comment('0:failed 1:sent message');
            $table->timestamp('DATE_SEND')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SMS_LOG');
    }
}
