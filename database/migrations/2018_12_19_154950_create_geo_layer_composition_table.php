<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeoLayerCompositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_layer_composition', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('layer_id')->unsigned();
            $table->foreign('layer_id')->references('id')->on('geo_layers');
            $table->enum('geometry_type', ['point', 'linestring', 'polygon']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('style');
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
        Schema::dropIfExists('geo_layer_composition');
    }
}
