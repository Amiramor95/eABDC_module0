<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDASHBOARDCHARTTYPETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DASHBOARD_CHART_TYPE', function (Blueprint $table) {
            $table->integer('CHART_ID', true);
            $table->string('CHART_NAME', 200);
            $table->string('DISPLAY_SIZE', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DASHBOARD_CHART_TYPE');
    }
}
