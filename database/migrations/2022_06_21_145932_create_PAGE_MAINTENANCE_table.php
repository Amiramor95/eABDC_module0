<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePAGEMAINTENANCETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PAGE_MAINTENANCE', function (Blueprint $table) {
            $table->integer('PAGE_MAINTENANCE_ID', true);
            $table->date('MAINTENANCE_START_DATE');
            $table->date('MAINTENANCE_END_DATE');
            $table->string('NOTIFICATION_DESC');
            $table->integer('AUDIENCE');
            $table->string('MAINTENANCE_MODULE', 500);
            $table->integer('CREATION_BY');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PAGE_MAINTENANCE');
    }
}
