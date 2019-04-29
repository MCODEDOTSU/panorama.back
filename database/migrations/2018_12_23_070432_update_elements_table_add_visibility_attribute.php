<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateElementsTableAddVisibilityAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geo_elements', function (Blueprint $table) {
            $table->enum('visibility', ['shown', 'hidden'])->default('shown');
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
            $table->dropColumn('visibility');
        });
    }
}
