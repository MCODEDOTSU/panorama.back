<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

class LayerComposition extends Model
{
    protected $table = 'geo_layer_composition';

    protected $fillable = [
        'layer_id',
        'geometry_type',
        'title',
        'description',
        'style'
    ];

    /**
     * Слой
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function layer()
    {
        return $this->belongsTo(Layer::class);
    }
}
