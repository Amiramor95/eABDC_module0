<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFIMMUSERLOGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FIMM_USER_LOG', function (Blueprint $table) {
            $table->integer('LOG_ID', true);
            $table->integer('USER_ID')->nullable()->default(0);
            $table->string('LOG_IP', 200)->nullable();
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
        Schema::dropIfExists('FIMM_USER_LOG');
    }
}
