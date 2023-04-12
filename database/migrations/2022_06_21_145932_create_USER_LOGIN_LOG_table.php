<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUSERLOGINLOGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('USER_LOGIN_LOG', function (Blueprint $table) {
            $table->integer('USER_LOG_ID', true);
            $table->integer('USER_ID');
            $table->integer('USER_TYPE')->comment('1: FIMM,2: DISTRIBUTOR,3:CONSULTANT,4:OTHERS');
            $table->timestamp('CREATE_TIMESTAMP')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('USER_LOGIN_LOG');
    }
}
