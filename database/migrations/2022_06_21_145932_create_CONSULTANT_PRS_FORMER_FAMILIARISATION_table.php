<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTPRSFORMERFAMILIARISATIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_PRS_FORMER_FAMILIARISATION', function (Blueprint $table) {
            $table->integer('CONSULTANT_PRS_FORMER_FAMILIARISATION_ID', true);
            $table->date('CONSULTANT_PRS_FORMER_START_DATE');
            $table->date('CONSULTANT_PRS_FORMER_END_DATE');
            $table->date('CONSULTANT_PRS_FORMER_EFFECTIVE_DATE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_PRS_FORMER_FAMILIARISATION');
    }
}
