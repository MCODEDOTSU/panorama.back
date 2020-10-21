<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPassportToPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('passport_series', 4)->nullable();
            $table->string('passport_number', 6)->nullable();
            $table->string('passport_issued_by')->nullable();
            $table->date('passport_issued_when')->nullable();
            $table->string('passport_department_number', 7)->nullable();
            $table->text('own')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn('passport_series');
            $table->dropColumn('passport_number');
            $table->dropColumn('passport_issued_by');
            $table->dropColumn('passport_issued_when');
            $table->dropColumn('passport_department_number');
            $table->dropColumn('own');
        });
    }
}
