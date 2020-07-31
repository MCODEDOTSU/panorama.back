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
    protected $table = 'person';

    protected $fillable = [
        'id', 'firstname', 'lastname', 'middlename', 'date_of_birth', 'address_id', 'phones', 'note'
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
        return $this->belongsTo(Address::class);
    }

}
