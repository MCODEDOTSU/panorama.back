<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Directory
 * @package App\src\Models
 */
class Directory extends Model
{
    protected $table = 'directories';

    protected $fillable = [
        'id', 'name', 'title'
    ];

}
