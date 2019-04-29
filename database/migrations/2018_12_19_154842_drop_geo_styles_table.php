<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropGeoStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('geo_styles');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('geo_styles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('layer_id')->unsigned();
            $table->foreign('layer_id')->references('id')->on('geo_layers');
            $table->json('style');
            $table->timestamps();
        });
    }
}
