<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMANAGEANNOUNCEMENTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('MANAGE_ANNOUNCEMENT', function (Blueprint $table) {
            $table->foreign(['MANAGE_DEPARTMENT_ID'], 'MANAGE_ANNOUNCEMENT_ibfk_1')->references(['MANAGE_DEPARTMENT_ID'])->on('MANAGE_DEPARTMENT')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('MANAGE_ANNOUNCEMENT', function (Blueprint $table) {
            $table->dropForeign('MANAGE_ANNOUNCEMENT_ibfk_1');
        });
    }
}
