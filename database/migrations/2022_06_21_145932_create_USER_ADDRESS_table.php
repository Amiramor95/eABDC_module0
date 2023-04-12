<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUSERADDRESSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('USER_ADDRESS', function (Blueprint $table) {
            $table->integer('USER_ADDRESS_ID', true);
            $table->integer('USER_ID')->index('USER_ID');
            $table->string('USER_ADDR_1', 100);
            $table->string('USER_ADDR_2', 100);
            $table->string('USER_ADDR_3', 100);
            $table->integer('USER_COUNTRY')->nullable();
            $table->integer('USER_CITY')->nullable();
            $table->integer('USER_STATE')->nullable();
            $table->integer('USER_POSTAL');
            $table->string('USER_PHONE', 50)->nullable();
            $table->timestamp('CREATE_TIMESTAMP')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('USER_ADDRESS');
    }
}
