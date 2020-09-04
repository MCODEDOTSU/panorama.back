<?php

namespace App\src\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @method find($id)
 * @method create($data)
 * @method where(string $string, string $string1, $id)
 */
class Address extends Model
{
    protected $table = 'address';

    protected $fillable = [
        'id', 'index', 'region_id', 'district', 'city', 'street', 'build'
    ];

    public function region()
    {
        return $this->belongsTo('App\src\Models\Region');
    }
}
