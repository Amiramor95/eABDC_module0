<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUSERAPPROVALTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('USER_APPROVAL', function (Blueprint $table) {
            $table->integer('USER_APPROVAL_ID', true);
            $table->integer('USER_ID')->index('USER_ID');
            $table->integer('USER_ROLE')->nullable()->comment('Reference APPROVAL_LEVEL');
            $table->integer('APPR_ID')->index('APPR_ID');
            $table->integer('USER_GROUP');
            $table->integer('APPR_TYPE');
            $table->string('APPR_REMARK', 500);
            $table->string('APPR_STATUS', 500)->comment('0: Inactive, 1: Pending 3: Approved,4: Return');
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
        Schema::dropIfExists('USER_APPROVAL');
    }
}
