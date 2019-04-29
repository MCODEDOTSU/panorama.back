<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGeoPolygonsTablePerimeterAreaField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geo_polygons', function (Blueprint $table) {
            $table->string('perimeter')->nullable()->change();
            $table->string('area')->nullable()->change();
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
            $table->string('perimeter')->change();
            $table->string('area')->change();
        });
    }
}
