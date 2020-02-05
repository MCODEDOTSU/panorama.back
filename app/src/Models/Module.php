<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'title', 'description'
    ];

    public function layers()
    {
        return $this->hasMany(Layer::class);
    }

    public function contractors()
    {
        return $this->belongsToMany(Contractor::class, 'privileges');
    }

}
