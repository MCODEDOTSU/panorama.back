<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method where(string $string, string $string1, string $alias)
 * @method create(array $recordData)
 * @method static find(int $id)
 * @property mixed alias
 * @property mixed title
 * @property mixed description
 * @property mixed parent_id
 * @property mixed module_id
 * @property mixed visibility
 * @property mixed geometry_type
 * @property mixed style
 */
class Layer extends Model
{
    protected $table = 'geo_layers';

    protected $fillable = [
        'alias', 'title', 'description', 'parent_id', 'module_id', 'visibility', 'geometry_type', 'style'
    ];

    /**
     * Модуль слоя
     * @return BelongsTo
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Родительский слой
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Layer::class);
    }

    /**
     * Элементы слоя
     * @return HasMany
     */
    public function elements()
    {
        return $this->hasMany(Element::class);
    }

}
