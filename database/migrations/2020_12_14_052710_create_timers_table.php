<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('timer_name');
            $table->integer('time');
            $table->integer('start_whistle_id')->unsigned()->nullable();
            $table->integer('end_whistle_id')->unsigned()->nullable();

            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();

            $table->foreign('start_whistle_id')
                ->references('id')
                ->on('whistles')
                ->onDelete('cascade');

            $table->foreign('end_whistle_id')
                ->references('id')
                ->on('whistles')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timers');
    }
}
