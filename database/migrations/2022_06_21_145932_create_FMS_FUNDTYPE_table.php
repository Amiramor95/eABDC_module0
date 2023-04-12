<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFMSFUNDTYPETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FMS_FUNDTYPE', function (Blueprint $table) {
            $table->integer('FMS_FUNDTYPE_ID', true);
            $table->string('FUND_NAME', 100);
            $table->string('FUND_TYPE_FULLNAME');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FMS_FUNDTYPE');
    }
}
