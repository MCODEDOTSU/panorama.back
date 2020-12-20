<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historyables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('history_id')->unsigned();
            $table->foreign('history_id')->references('id')->on('history');
            $table->integer('historyable_id')->unsigned()->index();
            $table->string('historyable_type')->unsigned();
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
        Schema::dropIfExists('historyables');
    }
}
