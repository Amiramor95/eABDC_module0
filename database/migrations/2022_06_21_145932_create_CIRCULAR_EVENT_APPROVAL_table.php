<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCIRCULAREVENTAPPROVALTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CIRCULAR_EVENT_APPROVAL', function (Blueprint $table) {
            $table->integer('CIRCULAR_EVENT_APPROVAL_ID', true);
            $table->integer('CIRCULAR_EVENT_ID');
            $table->string('APPR_REMARK', 500)->nullable();
            $table->integer('APPR_STATUS')->nullable()->comment('1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 3:HOD RETURN 4:GM APPROVED 5:GM RETURN 6:REJECTED 7: HOD SAVE AS DRAFT 8: GM SAVE AS DRAFT');
            $table->integer('CREATE_BY')->nullable();
            $table->timestamp('CREATE_TIMESTAMP')->useCurrent();
            $table->integer('APPR_GROUP_ID')->nullable();
            $table->integer('APPROVAL_LEVEL_ID')->nullable();
            $table->integer('TS_ID')->nullable();
            $table->integer('APPR_PUBLISH_STATUS')->nullable()->comment('1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 3:HOD RETURN 4:GM APPROVED 5:GM RETURN 6:REJECTED ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CIRCULAR_EVENT_APPROVAL');
    }
}
