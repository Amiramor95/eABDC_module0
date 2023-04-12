<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFINANCECODETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FINANCE_CODE', function (Blueprint $table) {
            $table->integer('FINANCE_CODE_ID', true);
            $table->integer('DIST_ID')->index('DIST_ID');
            $table->string('FIN_DISTRIBUTOR_NAME', 200);
            $table->string('FIN_CODE', 50);
            $table->integer('STATUS')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FINANCE_CODE');
    }
}
