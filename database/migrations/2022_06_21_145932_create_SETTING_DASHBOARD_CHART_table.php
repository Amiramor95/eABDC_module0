<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGDASHBOARDCHARTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_DASHBOARD_CHART', function (Blueprint $table) {
            $table->integer('SETTING_DASHBOARD_CHART_ID', true);
            $table->integer('SETTING_DASHBOARD_CHART_INDEX');
            $table->integer('SETTING_DASHBOARD_CHART_TYPE')->comment('0:horizontal bar,  1: vertical bar,2:line, 3:pie, 4:donut, 5:stack bar');
            $table->string('SETTING_DASHBOARD_CHART_LABEL', 100);
            $table->integer('SETTING_DASHBOARD_CHART_MODULE_ID');
            $table->integer('SETTING_DASHBOARD_CHART_USER_ID');
            $table->string('SETTING_DASHBOARD_CHART_CLASS', 50)->comment('CSS class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_DASHBOARD_CHART');
    }
}
