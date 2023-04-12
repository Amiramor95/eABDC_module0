<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTAPPROVALLEVELTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DIST_APPROVAL_LEVEL', function (Blueprint $table) {
            $table->integer('DIST_APPROVAL_LEVEL_ID', true);
            $table->integer('DIST_APPR_GROUP_ID');
            $table->string('DIST_APPR_LEVEL_NAME', 200);
            $table->integer('DIST_APPR_PREDECESSOR')->nullable();
            $table->integer('DIST_APPR_AUTO_APPROVAL_DAYS')->nullable();
            $table->integer('DIST_APPR_AUTO_REJECT_DAYS')->nullable();
            $table->string('DIST_APPR_DISTRIBUTOR_CATEGORY', 20)->nullable();
            $table->string('DIST_APPR_OTHERS_CATEGORY', 20)->nullable();
            $table->integer('DIST_APPR_PROCESSFLOW_ID');
            $table->integer('DIST_APPR_STATUS');
            $table->integer('DIST_APPR_INDEX');
            $table->integer('CREATE_BY');
            $table->timestamp('CREATE_TIMESTAMP');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DIST_APPROVAL_LEVEL');
    }
}
