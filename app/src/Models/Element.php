<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;

/**
 * @method where(string $string, string $string1, $name)
 * @method join(string $string, string $string1, string $string2, string $string3)
 * @method select(Expression $raw)
 * @method create(array $value)
 * @method find($id)
 * @property mixed geometry
 * @property mixed title
 * @property mixed description
 * @property mixed address_id
 * @property mixed layer_id
 * @property mixed visibility
 * @property mixed id
 */
class Element extends Model
{
    protected $table = 'geo_elements';

    protected $fillable = [
        'layer_id', 'title', 'description', 'address_id', 'geometry', 'length', 'area', 'perimeter'
    ];

    /**
     * Следующие элементы
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function next()
    {
        return $this->hasMany(ElementGraph::class);
    }

}
