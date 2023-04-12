<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDATARETENTIONTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DATA_RETENTION', function (Blueprint $table) {
            $table->integer('DATA_RETENTION_ID', true);
            $table->integer('RETENTION_DURATION');
            $table->timestamp('CREATED_AT')->useCurrent();
            $table->timestamp('UPDATED_AT')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DATA_RETENTION');
    }
}
