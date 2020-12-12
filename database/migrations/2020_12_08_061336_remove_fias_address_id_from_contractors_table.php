<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFiasAddressIdFromContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contractors', function (Blueprint $table) {
            if (Schema::hasColumn('contractors', 'fias_address_id')) {
                $table->dropColumn('fias_address_id');
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractors', function (Blueprint $table) {
            if (!Schema::hasColumn('contractors', 'fias_address_id')) {
                $table->integer('fias_address_id')->unsigned()->nullable();
                $table->foreign('fias_address_id')->references('id')->on('fias_address');
            }
        });
    }
}
