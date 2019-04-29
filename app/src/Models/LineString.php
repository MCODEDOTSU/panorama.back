<?php

namespace App\src\Models;


use Illuminate\Database\Eloquent\Model;

class LineString extends Model
{
    protected $table = 'geo_linestrings';

    protected $fillable = [
        'element_id',
        'geom',
        'address_id',
        'length',
        'title',
        'description',
        'data',
        'layer_composition_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
