<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORAPPROVALLEVELTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_APPROVAL_LEVEL', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_APPROVAL_LEVEL_ID', true);
            $table->integer('APPR_GROUP_ID');
            $table->string('APPR_LEVEL_NAME', 200);
            $table->integer('APPR_PREDECESSOR')->nullable();
            $table->integer('APPR_AUTO_APPROVAL_DAYS')->nullable();
            $table->integer('APPR_AUTO_REJECT_DAYS')->nullable();
            $table->string('APPR_OTHERS_CATEGORY', 200)->nullable();
            $table->integer('APPR_PROCESSFLOW_ID');
            $table->tinyInteger('APPR_STATUS')->nullable();
            $table->tinyInteger('APPR_INDEX')->comment('sorting level group');
            $table->integer('CREATE_BY')->nullable();
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
        Schema::dropIfExists('DISTRIBUTOR_APPROVAL_LEVEL');
    }
}
