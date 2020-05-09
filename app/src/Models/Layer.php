<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
