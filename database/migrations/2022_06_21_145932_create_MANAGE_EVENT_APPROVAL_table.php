<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGEEVENTAPPROVALTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_EVENT_APPROVAL', function (Blueprint $table) {
            $table->integer('MANAGE_EVENT_APPROVAL_ID', true);
            $table->integer('MANAGE_EVENT_ID')->nullable()->index('MANAGE_EVENT_ID');
            $table->integer('APPR_GROUP_ID');
            $table->integer('APPROVAL_LEVEL_ID');
            $table->string('APPR_REMARK', 500)->nullable();
            $table->integer('TS_ID')->nullable();
            $table->tinyInteger('APPR_STATUS')->nullable()->comment('1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 3:HOD RETURN 4:HOD SAVE AS DRAFT');
            $table->integer('CREATE_BY')->nullable();
            $table->timestamp('CREATE_TIMESTAMP')->nullable()->useCurrent();
            $table->string('STAFF_NAME', 259)->nullable();
            $table->tinyInteger('APPR_PUBLISH_STATUS')->comment('1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 3:HOD RETURN 4:HOD SAVE AS DRAFT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_EVENT_APPROVAL');
    }
}
