<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTBANKRUPTCYTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_BANKRUPTCY', function (Blueprint $table) {
            $table->integer('CONSULTANT_BANKRUPTCY_ID', true);
            $table->integer('BANKRUPTCY_DAY')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_BANKRUPTCY');
    }
}
