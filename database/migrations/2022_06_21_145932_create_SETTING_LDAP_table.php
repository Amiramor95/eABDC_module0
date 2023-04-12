<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGLDAPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_LDAP', function (Blueprint $table) {
            $table->integer('SETTING_IDAP_ID', true);
            $table->string('LDAP_ATTR_RDN', 100);
            $table->string('LDAP_ATTR_UUID', 100);
            $table->string('LDAP_USER_OBJ', 100);
            $table->string('LDAP_CONN_URL', 100);
            $table->string('LDAP_USER_DN', 100);
            $table->string('LDAP_USER_FILTER', 100);
            $table->string('LDAP_SEARCH_SCOPE', 100);
            $table->string('LDAP_BIND_TYPE', 100);
            $table->string('LDAP_BIND_DN', 100);
            $table->string('LDAP_BIND_CRED', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_LDAP');
    }
}
