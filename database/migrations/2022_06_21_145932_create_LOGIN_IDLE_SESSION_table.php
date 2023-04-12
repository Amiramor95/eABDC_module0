<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLOGINIDLESESSIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LOGIN_IDLE_SESSION', function (Blueprint $table) {
            $table->integer('LOGIN_IDLE_SESSION_ID', true);
            $table->integer('LOGIN_IDLE_SESSION_MIN');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LOGIN_IDLE_SESSION');
    }
}
