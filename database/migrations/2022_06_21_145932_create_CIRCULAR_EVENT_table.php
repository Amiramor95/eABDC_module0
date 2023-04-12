<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCIRCULAREVENTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CIRCULAR_EVENT', function (Blueprint $table) {
            $table->integer('CIRCULAR_EVENT_ID', true);
            $table->integer('MANAGE_CIRCULAR_ID')->nullable();
            $table->boolean('DEPARTMENT')->nullable()->comment('1:RD , 2:LRA, 3:SUPERVISION, 4:IDS, 5:PDS, 6:RA, 7:IT, 8:FIN');
            $table->string('EVENT_TITLE', 1000)->nullable();
            $table->string('EVENT_CONTENT', 10000)->nullable();
            $table->date('EVENT_DATE_START')->nullable();
            $table->date('EVENT_DATE_END')->nullable();
            $table->string('EVENT_DISTRIBUTOR_AUDIENCE', 500)->nullable();
            $table->string('EVENT_CONSULTANT_AUDIENCE', 500)->nullable();
            $table->string('EVENT_OTHER_AUDIENCE', 500)->nullable();
            $table->integer('TS_ID')->nullable()->comment('REFER  TS_ID IN TASK_STATUS TABLE AT ADMIN_MANAGEMENT ');
            $table->tinyInteger('PUBLISH_STATUS')->default(0)->comment('1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 3:HOD RETURN 4:GM APPROVED 5:GM RETURN 6:REJECTED 7: HOD SAVE AS DRAFT 8: GM SAVE AS DRAFT');
            $table->integer('CREATE_BY');
            $table->timestamp('CREATE_TIMESTAMP')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CIRCULAR_EVENT');
    }
}
