<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGeoElementsTableAddPrevNext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geo_elements', function (Blueprint $table) {
            $table->integer('element_next_id')->unsigned()->nullable();
            $table->foreign('element_next_id')->references('id')->on('geo_elements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geo_elements', function (Blueprint $table) {
            $table->dropColumn('element_next_id');
        });
    }
}
