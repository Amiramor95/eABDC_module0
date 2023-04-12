<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGEFORMTEMPLATETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_FORM_TEMPLATE', function (Blueprint $table) {
            $table->integer('MANAGE_FORM_TEMPLATE_ID', true);
            $table->integer('MANAGE_MODULE_ID')->index('MOD_ID');
            $table->string('TEMP_TITLE', 100);
            $table->string('TEMP_FILENAME', 100);
            $table->binary('FILE_BLOB');
            $table->text('FILE_MIMETYPE');
            $table->string('TEMP_FILEEXTENSION', 15);
            $table->decimal('TEMP_FILESIZE', 11, 0);
            $table->string('TEMP_DESCRIPTION', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_FORM_TEMPLATE');
    }
}
