<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDECLARATIONSETTINGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DECLARATION_SETTING', function (Blueprint $table) {
            $table->integer('DECLARATION_SETTING_ID', true);
            $table->string('DECLARATION_SET_TYPE');
            $table->string('DECLARATION_SET_PARAM', 200);
            $table->text('DECLARATION_DESCRIPTION');
            $table->integer('DECLARATION_SET_INDEX');
            $table->integer('CREATE_BY');
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
        Schema::dropIfExists('DECLARATION_SETTING');
    }
}
