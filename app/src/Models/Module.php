<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method get()
 * @method find($id)
 * @method create(array $array)
 */
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

    /**
     * Контрагенты, назначенные напрямую
     * @return BelongsToMany
     */
    public function contractors()
    {
        return $this->belongsToMany(Contractor::class, 'privileges');
    }

    /**
     * Контрагенты назначенные от родительского контрагента
     * @return BelongsToMany
     */
    public function parentContractors()
    {
        return $this->belongsToMany(Contractor::class,
            'privileges', 'module_id', 'contractor_id', 'id', 'parent_id');
    }

}
