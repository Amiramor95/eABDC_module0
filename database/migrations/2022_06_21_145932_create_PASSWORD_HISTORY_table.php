<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePASSWORDHISTORYTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PASSWORD_HISTORY', function (Blueprint $table) {
            $table->integer('PASSWORD_HISTORY_ID', true);
            $table->string('KEYCLOAK_ID', 100)->nullable();
            $table->string('PASSWORD', 200)->nullable();
            $table->string('SECRET', 80)->nullable();
            $table->timestamp('UPDATED_DATE')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PASSWORD_HISTORY');
    }
}
