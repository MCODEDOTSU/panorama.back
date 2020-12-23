<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class History
 * @package App\src\Models
 */
class History extends Model
{
    protected $table = 'history';

    protected $fillable = [
        'text', 'create_user_id', 'type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function create_user()
    {
        return $this->belongsTo(User::class, 'create_user_id')->with('person');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function update_user()
    {
        return $this->belongsTo(User::class, 'update_user_id')->with('person');
    }

}
