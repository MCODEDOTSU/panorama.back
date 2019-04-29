<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGeoPolygonsTableAddCompositionIdField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geo_polygons', function (Blueprint $table) {
            $table->integer('layer_composition_id')->unsigned();
            $table->foreign('layer_composition_id')->references('id')->on('geo_layer_composition');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geo_polygons', function (Blueprint $table) {
            $table->dropColumn('layer_composition_id');
        });
    }
}
