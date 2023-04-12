<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMANAGEGROUPTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MANAGE_GROUP', function (Blueprint $table) {
            $table->integer('MANAGE_GROUP_ID', true);
            $table->integer('MANAGE_DEPARTMENT_ID')->nullable()->index('DPMT_ID');
            $table->string('GROUP_NAME', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MANAGE_GROUP');
    }
}
