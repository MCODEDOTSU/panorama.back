<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class History
 * @package App\src\Models
 */
class History extends Model
{
    protected $table = 'history';

    protected $fillable = [
        'text', 'create_user_id', 'type',
    ];

}
