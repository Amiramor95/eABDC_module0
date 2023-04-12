<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTDESIGNATIONEXEMPTIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_DESIGNATION_EXEMPTION', function (Blueprint $table) {
            $table->integer('CONSULTANT_DESIGNATION_EXEMPTION_ID', true);
            $table->string('EXEM_NAME', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_DESIGNATION_EXEMPTION');
    }
}
