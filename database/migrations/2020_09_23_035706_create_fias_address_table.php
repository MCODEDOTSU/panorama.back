<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiasAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fias_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('unrestricted_value');
            $table->string('area')->nullable();
            $table->string('area_fias_id')->nullable();
            $table->string('area_kladr_id')->nullable();
            $table->string('area_type')->nullable();
            $table->string('area_type_full')->nullable();
            $table->string('area_with_type')->nullable();
            $table->string('beltway_distance')->nullable();
            $table->string('beltway_hit')->nullable();
            $table->string('block')->nullable();
            $table->string('block_type')->nullable();
            $table->string('block_type_full')->nullable();
            $table->string('capital_marker')->nullable();
            $table->string('city')->nullable();
            $table->string('city_area')->nullable();
            $table->string('city_district')->nullable();
            $table->string('city_district_fias_id')->nullable();
            $table->string('city_district_kladr_id')->nullable();
            $table->string('city_district_type')->nullable();
            $table->string('city_district_type_full')->nullable();
            $table->string('city_district_with_type')->nullable();
            $table->string('city_fias_id')->nullable();
            $table->string('city_kladr_id')->nullable();
            $table->string('city_type')->nullable();
            $table->string('city_type_full')->nullable();
            $table->string('city_with_type')->nullable();
            $table->string('country')->nullable();
            $table->string('country_iso_code')->nullable();
            $table->string('federal_district')->nullable();
            $table->string('fias_actuality_state')->nullable();
            $table->string('fias_code')->nullable();
            $table->string('fias_id')->nullable();
            $table->string('fias_level')->nullable();
            $table->string('flat')->nullable();
            $table->string('flat_area')->nullable();
            $table->string('flat_price')->nullable();
            $table->string('flat_type')->nullable();
            $table->string('flat_type_full')->nullable();
            $table->string('geo_lat')->nullable();
            $table->string('geo_lon')->nullable();
            $table->string('geoname_id')->nullable();
            $table->string('history_values')->nullable();
            $table->string('house')->nullable();
            $table->string('house_fias_id')->nullable();
            $table->string('house_kladr_id')->nullable();
            $table->string('house_type')->nullable();
            $table->string('house_type_full')->nullable();
            $table->string('kladr_id')->nullable();
            $table->string('metro')->nullable();
            $table->string('okato')->nullable();
            $table->string('oktmo')->nullable();
            $table->string('postal_box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('qc')->nullable();
            $table->string('qc_complete')->nullable();
            $table->string('qc_geo')->nullable();
            $table->string('qc_house')->nullable();
            $table->string('region')->nullable();
            $table->string('region_fias_id')->nullable();
            $table->string('region_iso_code')->nullable();
            $table->string('region_kladr_id')->nullable();
            $table->string('region_type')->nullable();
            $table->string('region_type_full')->nullable();
            $table->string('region_with_type')->nullable();
            $table->string('settlement')->nullable();
            $table->string('settlement_fias_id')->nullable();
            $table->string('settlement_kladr_id')->nullable();
            $table->string('settlement_type')->nullable();
            $table->string('settlement_type_full')->nullable();
            $table->string('settlement_with_type')->nullable();
            $table->string('source')->nullable();
            $table->string('square_meter_price')->nullable();
            $table->string('street')->nullable();
            $table->string('street_fias_id')->nullable();
            $table->string('street_kladr_id')->nullable();
            $table->string('street_type')->nullable();
            $table->string('street_type_full')->nullable();
            $table->string('street_with_type')->nullable();
            $table->string('tax_office')->nullable();
            $table->string('tax_office_legal')->nullable();
            $table->string('timezone')->nullable();
            $table->string('unparsed_parts')->nullable();
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
        Schema::dropIfExists('fias_address');
    }
}
