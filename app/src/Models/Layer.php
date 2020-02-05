<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

class Layer extends Model
{
    protected $table = 'geo_layers';

    protected $fillable = [
        'alias', 'title', 'description', 'parent_id', 'module_id', 'visibility', 'geometry_type', 'style'
    ];

    /**
     * Модуль слоя
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Родительский слой
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Layer::class);
    }

    /**
     * Элементы слоя
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elements()
    {
        return $this->hasMany(Element::class);
    }

}
