<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCPDREVOCATIONAPPROVALTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CPD_REVOCATION_APPROVAL', function (Blueprint $table) {
            $table->integer('REVOCATION_ID', true);
            $table->integer('REVOCATION_APPROVAL_DAYS')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CPD_REVOCATION_APPROVAL');
    }
}
