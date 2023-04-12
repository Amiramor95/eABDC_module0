<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGEREQUIREDDOCUMENTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_REQUIRED_DOCUMENT', function (Blueprint $table) {
            $table->integer('MANAGE_REQUIRED_DOCUMENT_ID', true);
            $table->integer('MANAGE_SUBMODULE_ID')->index('SUBMOD_ID');
            $table->integer('REQ_DOCU_TYPE');
            $table->string('REQ_DOCU_SECTION', 300)->nullable();
            $table->string('REQ_DOCU_NAME', 500);
            $table->string('REQ_DOCU_DESCRIPTION', 500)->nullable();
            $table->tinyInteger('REQ_DOCU_STATUS');
            $table->integer('REQ_DOCU_INDEX');
            $table->string('AUDIENCE_TYPE', 200);
            $table->string('AUDIENCE_ID', 100);
            $table->integer('CREATE_BY');
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
        Schema::dropIfExists('MANAGE_REQUIRED_DOCUMENT');
    }
}
