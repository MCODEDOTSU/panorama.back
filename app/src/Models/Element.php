<?php

namespace App\src\Models;


use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $table = 'geo_elements';

    protected $fillable = [
        'layer_id', 'title', 'description', 'address_id', 'geometry', 'length', 'area', 'perimeter', 'element_next_id'
    ];

}
