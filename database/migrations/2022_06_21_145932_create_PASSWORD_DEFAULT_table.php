<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePASSWORDDEFAULTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PASSWORD_DEFAULT', function (Blueprint $table) {
            $table->integer('PASSWORD_DEFAULT_ID', true);
            $table->integer('PASSWORD_DEFAULT_VALUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PASSWORD_DEFAULT');
    }
}
