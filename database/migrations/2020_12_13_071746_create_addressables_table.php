<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addressables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fias_address_id')->unsigned();
            $table->foreign('fias_address_id')->references('id')->on('fias_address');
            $table->integer('addressable_id')->unsigned()->index();
            $table->string('addressable_type')->unsigned();
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
        Schema::dropIfExists('addressables');
    }
}
