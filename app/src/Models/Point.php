<?php

namespace App\src\Models;


use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'geo_points';

    protected $fillable = [
        'element_id',
        'geom',
        'address_id',
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
