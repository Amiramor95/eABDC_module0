<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFMSFUNDDOMICILETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FMS_FUND_DOMICILE', function (Blueprint $table) {
            $table->integer('FUND_DOMICILE_ID', true);
            $table->string('FUND_DOMICILE_NAME', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FMS_FUND_DOMICILE');
    }
}
