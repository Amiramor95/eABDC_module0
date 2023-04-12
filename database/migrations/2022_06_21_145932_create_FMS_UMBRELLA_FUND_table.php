<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFMSUMBRELLAFUNDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FMS_UMBRELLA_FUND', function (Blueprint $table) {
            $table->integer('FMS_UMBRELLA_FUND_ID', true);
            $table->string('UMBRELLA_FUND_NAME', 100)->nullable();
            $table->string('UMBRELLA_FUND_SIZE', 500)->nullable();
            $table->string('UMBRELLA_FUND_ACRO', 45)->nullable();
            $table->integer('UMBRELLA_FUND_INITIAL')->nullable();
            $table->integer('UMBRELLA_FUND_CURRENT')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FMS_UMBRELLA_FUND');
    }
}
