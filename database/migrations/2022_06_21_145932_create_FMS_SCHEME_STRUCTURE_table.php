<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFMSSCHEMESTRUCTURETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FMS_SCHEME_STRUCTURE', function (Blueprint $table) {
            $table->integer('FMS_SCHEME_ID', true);
            $table->string('FMS_SCHEME_NAME', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FMS_SCHEME_STRUCTURE');
    }
}
