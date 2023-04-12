<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOTHERSNOTIFICATIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OTHERS_NOTIFICATION', function (Blueprint $table) {
            $table->integer('OTHERS_NOTIFICATION_ID');
            $table->integer('NOTIFICATION_GROUP_ID')->nullable();
            $table->integer('COMPANY_ID')->nullable();
            $table->integer('OTHERS_TYPE')->nullable()->comment('Type of Others User :
1 - 3rd Party
2 - Training Provider
3 - Media');
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
        Schema::dropIfExists('OTHERS_NOTIFICATION');
    }
}
