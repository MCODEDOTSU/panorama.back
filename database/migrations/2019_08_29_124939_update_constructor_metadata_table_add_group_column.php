<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateConstructorMetadataTableAddGroupColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * поле group - предназначено для хранения данныхо о группе
         */
        Schema::table('constructor_metadata', function (Blueprint $table) {
            $table->string('group')->nullable();
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
            $table->dropColumn('group');
        });
    }
}
