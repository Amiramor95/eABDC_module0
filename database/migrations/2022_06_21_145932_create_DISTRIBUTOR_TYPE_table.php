<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDISTRIBUTORTYPETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DISTRIBUTOR_TYPE', function (Blueprint $table) {
            $table->integer('DISTRIBUTOR_TYPE_ID', true);
            $table->integer('ANNUALFEES_ID')->nullable();
            $table->string('DIST_TYPE_NAME', 100)->nullable();
            $table->string('DIST_TYPE_VARIATION', 100)->nullable();
            $table->string('SCHEME', 25)->nullable();
            $table->string('MARKETING_APPROACH_ID')->nullable();
            $table->string('TYPE_STRUCTURE_ID')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DISTRIBUTOR_TYPE');
    }
}
