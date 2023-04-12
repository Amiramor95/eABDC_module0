<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTRENEWALDATETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_RENEWAL_DATE', function (Blueprint $table) {
            $table->integer('CONSULTANT_RENEWAL_DATE_ID', true);
            $table->date('CONSULTANT_RENEWAL_START_DATE');
            $table->date('CONSULTANT_RENEWAL_END_DATE');
            $table->year('CONSULTANT_RENEWAL_YEAR')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_RENEWAL_DATE');
    }
}
