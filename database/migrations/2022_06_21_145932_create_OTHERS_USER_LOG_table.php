<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOTHERSUSERLOGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OTHERS_USER_LOG', function (Blueprint $table) {
            $table->integer('LOG_ID', true);
            $table->integer('USER_ID')->nullable();
            $table->string('LOG_IP', 200);
            $table->integer('STATUS')->default(0);
            $table->timestamp('LOGIN_TIMESTAMP')->nullable();
            $table->timestamp('LOGOUT_TIMESTAMP')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('OTHERS_USER_LOG');
    }
}
