<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGeoPointsTableGeomField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geo_points', function (Blueprint $table) {
            $table->string('geom')->nullable()->change();
            $table->integer('address_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geo_points', function (Blueprint $table) {
            $table->string('geom')->change();
            $table->integer('address_id')->unsigned()->change();
        });
    }
}
