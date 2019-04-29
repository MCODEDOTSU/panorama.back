<?php

namespace App\src\Models;


use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    protected $fillable = [
        'id',
        'index',
        'region',
        'city',
        'street',
        'build'
    ];
}
