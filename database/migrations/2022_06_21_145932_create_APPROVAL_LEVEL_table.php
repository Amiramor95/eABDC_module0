<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAPPROVALLEVELTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('APPROVAL_LEVEL', function (Blueprint $table) {
            $table->integer('APPROVAL_LEVEL_ID', true);
            $table->integer('APPR_GROUP_ID');
            $table->string('APPR_LEVEL_NAME', 200)->nullable();
            $table->integer('APPR_PREDECESSOR')->nullable();
            $table->integer('APPR_AUTO_APPROVAL_DAYS')->nullable();
            $table->integer('APPR_AUTO_REJECT_DAYS')->nullable();
            $table->string('APPR_DISTRIBUTOR_CATEGORY', 20)->nullable();
            $table->string('APPR_OTHERS_CATEGORY', 20)->nullable();
            $table->integer('APPR_PROCESSFLOW_ID')->nullable()->comment('PROCESS_FLOW');
            $table->boolean('APPR_STATUS')->default(false)->comment('1:OFF, 0:ON');
            $table->tinyInteger('APPR_INDEX')->default(0);
            $table->integer('CREATE_BY')->nullable();
            $table->timestamp('CREATE_TIMESTAMP')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('APPROVAL_LEVEL');
    }
}
