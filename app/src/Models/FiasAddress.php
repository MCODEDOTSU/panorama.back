<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method find($id)
 * @method create($data)
 * @method where(string $string, string $string1, $id)
 */
class FiasAddress extends Model
{
    protected $table = 'fias_address';

    protected $fillable = [
        'id', 'unrestricted_value', 'area', 'area_fias_id', 'area_kladr_id', 'area_type', 'area_type_full', 'area_with_type',
        'beltway_distance', 'beltway_hit', 'block', 'block_type', 'block_type_full',
        'capital_marker', 'city', 'city_area', 'city_district', 'city_district_fias_id', 'city_district_kladr_id',
        'city_district_type', 'city_district_type_full', 'city_district_with_type', 'city_fias_id', 'city_kladr_id',
        'city_type', 'city_type_full', 'city_with_type', 'country', 'country_iso_code', 'federal_district',
        'fias_actuality_state', 'fias_code', 'fias_id', 'fias_level', 'flat', 'flat_area', 'flat_price', 'flat_type',
        'flat_type_full', 'geo_lat', 'geo_lon', 'geoname_id', 'history_values', 'house', 'house_fias_id',
        'house_kladr_id', 'house_type', 'house_type_full', 'kladr_id', 'metro', 'okato', 'oktmo', 'postal_box',
        'postal_code', 'qc', 'qc_complete', 'qc_geo', 'qc_house', 'region', 'region_fias_id', 'region_iso_code',
        'region_kladr_id', 'region_type', 'region_type_full', 'region_with_type', 'settlement', 'settlement_fias_id',
        'settlement_kladr_id', 'settlement_type', 'settlement_type_full', 'settlement_with_type', 'source',
        'square_meter_price', 'street', 'street_fias_id', 'street_kladr_id', 'street_type', 'street_type_full',
        'street_with_type', 'tax_office', 'tax_office_legal', 'timezone', 'unparsed_parts'
    ];
}
