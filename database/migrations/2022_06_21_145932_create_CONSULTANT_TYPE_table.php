<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCONSULTANTTYPETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CONSULTANT_TYPE', function (Blueprint $table) {
            $table->integer('CONSULTANT_TYPE_ID', true);
            $table->string('TYPE_NAME', 100);
            $table->string('TYPE_SCHEME', 100)->nullable();
            $table->string('TYPE_FULL_NAME');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CONSULTANT_TYPE');
    }
}
