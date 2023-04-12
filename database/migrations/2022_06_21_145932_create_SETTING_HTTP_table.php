<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGHTTPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_HTTP', function (Blueprint $table) {
            $table->integer('SETTING_HTTP_ID', true);
            $table->string('USER_NAME', 100);
            $table->string('API_KEY', 200);
            $table->string('API_SECRET', 200);
            $table->string('ALLOW_IP');
            $table->string('DLR_URL', 100)->nullable();
            $table->string('MO_URL', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_HTTP');
    }
}
