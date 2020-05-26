<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;

/**
 * Class ElementGraph
 * @package App\src\Models
 */
class ElementGraph extends Model
{
    protected $table = 'elements_graph';

    protected $fillable = [
        'element_id', 'next_element_id'
    ];

    public function element()
    {
        return $this->belongsTo(Element::class, 'element_id');
    }

    public function next_element()
    {
        return $this->belongsTo(Element::class, 'next_element_id');
    }

}
