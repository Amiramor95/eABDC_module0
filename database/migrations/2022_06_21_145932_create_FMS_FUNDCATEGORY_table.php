<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFMSFUNDCATEGORYTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FMS_FUNDCATEGORY', function (Blueprint $table) {
            $table->integer('FMS_FUNDCATEGORY_ID', true);
            $table->string('GROUP_ASSET', 100)->nullable();
            $table->string('GROUP_FUND', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FMS_FUNDCATEGORY');
    }
}
