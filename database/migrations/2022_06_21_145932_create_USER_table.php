<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUSERTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('USER', function (Blueprint $table) {
            $table->integer('USER_ID', true);
            $table->string('KEYCLOAK_ID', 100);
            $table->string('USER_NAME', 100);
            $table->string('USER_EMAIL', 150)->nullable();
            $table->integer('USER_CITIZEN');
            $table->string('USER_NRIC', 12);
            $table->date('USER_DOB');
            $table->integer('USER_GROUP');
            $table->integer('USER_ISLOGIN')->nullable()->default(0)->comment('0: First, 1: Not First ');
            $table->integer('USER_STATUS')->nullable()->default(0)->comment('0: Inactive, 1: Pending 2: Approved,3: Returned');
            $table->integer('USER_ROLE')->nullable()->comment('Foreign Key of  AUTHORIZATION_LEVEL');
            $table->timestamp('LOGINTIME')->nullable();
            $table->timestamp('LAST_SEEN_AT')->nullable();
            $table->integer('ISLOGIN')->default(0);
            $table->timestamp('CREATE_TIMESTAMP')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('USER');
    }
}
