<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMAINMODULETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MAIN_MODULE', function (Blueprint $table) {
            $table->integer('MODULEID', true);
            $table->string('MODULENAME', 200);
            $table->integer('STATUS')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MAIN_MODULE');
    }
}
