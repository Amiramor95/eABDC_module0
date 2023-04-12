<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDASHBOARdMAINSETTINGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DASHBOARd_MAIN_SETTING', function (Blueprint $table) {
            $table->integer('DASHBOARD_MAIN_ID', true);
            $table->string('DASHBOARD_TYPE', 150)->nullable();
            $table->integer('DASHBOARD_SUB_TYPE')->default(0);
            $table->string('DASHBOARD_LIST', 200)->nullable();
            $table->string('DASHBOARD_DESCRIPTION', 200)->nullable();
            $table->integer('GRAPH_ID')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DASHBOARd_MAIN_SETTING');
    }
}
