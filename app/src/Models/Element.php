<?php

namespace App\src\Models;


use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $table = 'geo_elements';

    protected $fillable = [
        'layer_id',
        'title',
        'description',
        'visibility',
    ];

    /**
     * Точки элемента
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points()
    {
        return $this->hasMany(Point::class);
    }

    /**
     * Линии
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function linestrings()
    {
        return $this->hasMany(LineString::class);
    }

    /**
     * Полигоны
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function polygons()
    {
        return $this->hasMany(Polygon::class);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($element) {
            $element->points()->delete();
            $element->linestrings()->delete();
            $element->polygons()->delete();
        });
    }
}
