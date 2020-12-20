<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Person
 * @package App\src\Models
 */
class Person extends Model
{
    protected $table = 'persons';

    protected $fillable = [
        'id',
        'firstname',
        'lastname',
        'middlename',
        'date_of_birth',
        'fias_address_id',
        'phones',
        'note',
        'post',
        'photo',
        'passport_series',
        'passport_number',
        'passport_issued_by',
        'passport_issued_when',
        'passport_department_number',
        'own',
        'status',
    ];

    protected $casts = [
        'phones' => 'object',
        'note' => 'object',
    ];

    protected $attributes = [
        'phones' => '{}',
        'note' => '{}',
    ];

    /**
     * @return HasMany
     * К ФЛ могут быть привязаны несколько пользователей
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return BelongsTo
     * Адрес ФЛ
     */
    public function address()
    {
        return $this->belongsTo(FiasAddress::class, 'fias_address_id');
    }

    /**
     * История ФЛ
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function history()
    {
        return $this->morphToMany(History::class, 'historyable');
    }

}
