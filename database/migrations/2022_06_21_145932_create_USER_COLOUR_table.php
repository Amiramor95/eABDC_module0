<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUSERCOLOURTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('USER_COLOUR', function (Blueprint $table) {
            $table->integer('USER_COLOUR_ID', true);
            $table->integer('USER_ID');
            $table->integer('COLOUR_ID');
            $table->timestamp('CREATED_AT')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('USER_COLOUR');
    }
}
