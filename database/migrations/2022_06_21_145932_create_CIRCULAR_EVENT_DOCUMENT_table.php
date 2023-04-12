<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCIRCULAREVENTDOCUMENTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CIRCULAR_EVENT_DOCUMENT', function (Blueprint $table) {
            $table->integer('CIRCULAR_EVENT_DOCUMENT_ID', true);
            $table->integer('CIRCULAR_EVENT_ID')->nullable()->index('CIRCULAR_EVENT_ID');
            $table->string('DOC_MIMETYPE', 100)->nullable();
            $table->string('DOC_FILETYPE', 40)->nullable();
            $table->string('DOC_ORIGINAL_NAME', 200)->nullable();
            $table->binary('DOC_BLOB')->nullable();
            $table->integer('DOC_FILESIZE')->nullable();
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
        Schema::dropIfExists('CIRCULAR_EVENT_DOCUMENT');
    }
}
