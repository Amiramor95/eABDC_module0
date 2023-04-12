<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIDMASKINGSETTINGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ID_MASKING_SETTING', function (Blueprint $table) {
            $table->integer('MASKING_ID', true);
            $table->string('MASKING_TYPE', 100);
            $table->string('PREFIX', 200);
            $table->integer('RUN_NO');
            $table->integer('CURRENT_RUN_NO');
            $table->string('STATUS', 20);
            $table->text('DESCRIPTION');
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
        Schema::dropIfExists('ID_MASKING_SETTING');
    }
}
