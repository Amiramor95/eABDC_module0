<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSETTINGCALENDARTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SETTING_CALENDAR', function (Blueprint $table) {
            $table->integer('SETTING_CALENDAR_ID', true);
            $table->string('CALENDAR_NAME', 50)->nullable();
            $table->date('CALENDAR_DATE_START')->nullable();
            $table->date('CALENDAR_DATE_END')->nullable();
            $table->string('CALENDAR_DESCRIPTION', 500)->nullable();
            $table->integer('CREATE_BY')->nullable()->index('CREATE_BY');
            $table->timestamp('CREATE_TIMESTAMP')->useCurrent();
            $table->string('NRIC', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SETTING_CALENDAR');
    }
}
