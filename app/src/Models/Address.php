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
        'id', 'index', 'region', 'city', 'street', 'build'
    ];
}
