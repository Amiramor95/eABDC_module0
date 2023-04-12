<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGEEVENTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_EVENT', function (Blueprint $table) {
            $table->integer('MANAGE_EVENT_ID', true);
            $table->tinyInteger('DEPARTMENT')->nullable()->comment('1:RD , 2:LRA, 3:SUPERVISION, 4:IDS, 5:PDS, 6:RA, 7:IT, 8:FIN');
            $table->integer('MANAGE_ANNOUNCEMENT_ID')->nullable()->index('MANAGE_ANNOUNCEMENT_ID')->comment('PLEASE DELETE THIS COLUMN');
            $table->string('EVENT_TITLE', 100)->nullable();
            $table->string('EVENT_CONTENT', 10000)->nullable();
            $table->date('EVENT_DATE_START')->nullable();
            $table->date('EVENT_DATE_END')->nullable();
            $table->string('EVENT_DISTRIBUTOR_AUDIENCE', 500)->nullable()->comment('Array of Distributor Type Id ');
            $table->string('EVENT_CONSULTANT_AUDIENCE', 500)->nullable()->comment('Array of Consultant Type Id ');
            $table->string('EVENT_OTHER_AUDIENCE', 500)->nullable()->comment('Array of Setting General Id ');
            $table->integer('TS_ID')->nullable()->comment('REFER TS_ID IN TASK_STATUS TABLE AT ADMIN_MANAGEMENT	');
            $table->tinyInteger('PUBLISH_STATUS')->default(0)->comment('1: SUBMIT 0:SAVE AS DRAFT 2:HOD APPROVED 3:HOD RETURN 4:HOD SAVE AS DRAFT');
            $table->integer('CREATE_BY')->nullable()->comment('REFER USER ID IN USER TABLE');
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
        Schema::dropIfExists('MANAGE_EVENT');
    }
}
