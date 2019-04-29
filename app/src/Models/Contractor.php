<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    protected $table = 'contractors';

    protected $fillable = [
        'id',
        'name',
        'full_name',
        'inn',
        'kpp',
        'address_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * Получить привилегии / модули контрагента
     */
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'privileges');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * К контрагенту могут быть привязаны несколько пользователей
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Адрес контрагента
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

}
