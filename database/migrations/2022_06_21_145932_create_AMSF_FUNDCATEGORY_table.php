<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAMSFFUNDCATEGORYTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AMSF_FUNDCATEGORY', function (Blueprint $table) {
            $table->integer('AMSF_FUNDCATEGORY_ID', true);
            $table->double('SALE_FROM');
            $table->double('SALE_TO');
            $table->string('FUND_CATEGORY', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('AMSF_FUNDCATEGORY');
    }
}
