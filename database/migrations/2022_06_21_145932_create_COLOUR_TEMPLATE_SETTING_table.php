<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCOLOURTEMPLATESETTINGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('COLOUR_TEMPLATE_SETTING', function (Blueprint $table) {
            $table->integer('COLOUR_SETTING_ID', true);
            $table->string('THEME_NAME', 100);
            $table->string('THEME_ACTIVE_COLOR', 20);
            $table->string('THEME_PASSIVE_COLOR', 20);
            $table->string('THEME_TEXT_COLOR', 100);
            $table->string('COLORSTATUS', 20);
            $table->integer('CREATE_BY');
            $table->integer('SET_DEFAULT')->default(0);
            $table->timestamp('CREATE_TIMESTAMP')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('COLOUR_TEMPLATE_SETTING');
    }
}
