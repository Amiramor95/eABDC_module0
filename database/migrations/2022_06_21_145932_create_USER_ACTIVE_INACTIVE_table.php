<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUSERACTIVEINACTIVETable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('USER_ACTIVE_INACTIVE', function (Blueprint $table) {
            $table->integer('USER_ACTIVE_INACTIVE_ID', true);
            $table->integer('DURATION');
            $table->boolean('IS_ACTIVE')->nullable()->default(false);
            $table->integer('TYPE')->nullable()->comment('1:FiMM USER,2:Distributor,3:Consultant,4:Third party,5:Training Provider');
            $table->timestamp('UPDATED_AT')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('USER_ACTIVE_INACTIVE');
    }
}
