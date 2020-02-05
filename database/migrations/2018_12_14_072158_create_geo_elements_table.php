<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('layer_id')->unsigned();
            $table->foreign('layer_id')->references('id')->on('geo_layers');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('address_id')->unsigned()->nullable();
            $table->foreign('address_id')->references('id')->on('address');
            $table->geometry('geometry')->nullable();
            $table->float('length')->nullable();
            $table->float('area')->nullable();
            $table->float('perimeter')->nullable();
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
        Schema::dropIfExists('geo_elements');
    }
}
