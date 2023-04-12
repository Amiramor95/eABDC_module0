<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKEYCLOAKADMINTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('KEYCLOAK_ADMIN', function (Blueprint $table) {
            $table->integer('KEYCLOAK_ADMIN_ID', true);
            $table->string('KEYCLOAK_ADMIN_USERNAME', 80);
            $table->string('KEYCLOAK_ADMIN_PASSWORD', 100);
            $table->string('KEYCLOAK_ADMIN_SECRET', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('KEYCLOAK_ADMIN');
    }
}
