<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed name
 * @property mixed full_name
 * @property mixed inn
 * @property mixed kpp
 * @method create($data)
 * @method static find(int $id)
 */
class Contractor extends Model
{
    protected $table = 'contractors';

    protected $fillable = [
        'id', 'name', 'full_name', 'inn', 'kpp', 'address_id', 'logo', 'parent_id'
    ];

    /**
     * @return BelongsToMany
     * Получить привилегии / модули контрагента
     */
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'privileges');
    }

    /**
     * @return HasMany
     * К контрагенту могут быть привязаны несколько пользователей
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return BelongsTo
     * Адрес контрагента
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

}
