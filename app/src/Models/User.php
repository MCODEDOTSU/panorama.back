<?php

namespace App\src\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * @method where(string $string, $email)
 * @method find(int $id)
 * @property mixed name
 * @property mixed email
 * @property mixed|string password
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'contractor_id', 'post', 'photo', 'role', 'person_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Пользователь привязан к контрагенту
     */
    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Пользователь привязан к ФЛ
     */
    public function person()
    {
        return $this->belongsTo(Contractor::class, 'person_id');
    }

    public function AauthAcessToken(){
        return $this->hasMany(OauthAccessToken::class);
    }
}
