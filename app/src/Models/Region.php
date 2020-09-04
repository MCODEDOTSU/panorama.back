<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method find($id)
 * @method create($data)
 * @method where(string $string, string $string1, $id)
 */
class Region extends Model
{
    protected $table = 'regions';

    protected $fillable = [
        'id', 'name'
    ];

}
