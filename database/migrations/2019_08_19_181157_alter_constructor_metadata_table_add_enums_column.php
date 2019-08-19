<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterConstructorMetadataTableAddEnumsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * enum поле - предназначено для хранения данных для OneFromMany и ManyFromMany
         */
        Schema::table('constructor_metadata', function (Blueprint $table) {
            $table->json('enums')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('constructor_metadata', function (Blueprint $table) {
            $table->dropColumn('enums');
        });
    }
}
