<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGDASHBOARDCARDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_DASHBOARD_CARD', function (Blueprint $table) {
            $table->integer('SETTING_DASHBOARD_CARD_ID', true);
            $table->integer('SETTING_DASHBOARD_CARD_INDEX');
            $table->string('SETTING_DASHBOARD_CARD_LABEL', 100);
            $table->string('SETTING_DASHBOARD_CARD_DESCRIPTION', 150)->nullable();
            $table->string('SETTING_DASHBOARD_CARD_ICON', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_DASHBOARD_CARD');
    }
}
