<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTLICENSEYEARTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_LICENSE_YEAR', function (Blueprint $table) {
            $table->integer('CONSULTANT_LICENSE_ID', true);
            $table->integer('LICENSE_YEAR');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_LICENSE_YEAR');
    }
}
