<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFILESIZESETTINGTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FILE_SIZE_SETTING', function (Blueprint $table) {
            $table->integer('FILE_SIZE_SETTING_ID', true);
            $table->integer('ADMIN_MODULE');
            $table->integer('DISTRIBUTOR_MODULE');
            $table->integer('CONSULTANT_MODULE');
            $table->integer('CAS_MODULE');
            $table->integer('CPD_MODULE');
            $table->integer('FMS_MODULE');
            $table->integer('FINANCE_MODULE');
            $table->integer('AMSF_MODULE');
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
        Schema::dropIfExists('FILE_SIZE_SETTING');
    }
}
