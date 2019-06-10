<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConstructorMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constructor_metadata', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_identifier'); // Название таблицы (идентификатор)
            $table->string('title'); // Название столбца (читабельное)
            $table->string('tech_title'); // Техническое название столбца
            $table->string('required'); // nullable столбца
            $table->string('type'); // Тип столбца (text_field, long_text_field, number_field, image_field...)
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
        Schema::dropIfExists('constructor_metadata');
    }
}
