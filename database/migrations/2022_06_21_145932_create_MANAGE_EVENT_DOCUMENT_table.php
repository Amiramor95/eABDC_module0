<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGEEVENTDOCUMENTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_EVENT_DOCUMENT', function (Blueprint $table) {
            $table->integer('MANAGE_EVENT_DOCUMENT_ID', true);
            $table->integer('MANAGE_EVENT_ID')->nullable()->index('MANAGE_EVENT_ID');
            $table->string('DOCUMENT_MIMETYPE', 100)->nullable();
            $table->string('DOCUMENT_FILETYPE', 40)->nullable();
            $table->string('DOCUMENT_FILENAME', 100)->nullable();
            $table->binary('DOCUMENT_BLOB')->nullable();
            $table->decimal('DOCUMENT_FILESIZE', 10)->nullable();
            $table->integer('CREATE_BY')->nullable();
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
        Schema::dropIfExists('MANAGE_EVENT_DOCUMENT');
    }
}
