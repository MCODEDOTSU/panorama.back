<?php

namespace App\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed name
 * @property mixed full_name
 * @property mixed inn
 * @property mixed kpp
 * @property mixed|null parent_id
 * @method create($data)
 * @method static find(int $id)
 */
class ContractorTos extends Model
{
    protected $table = 'contractors_tos';

    protected $fillable = [
        'id', 'contractor_id'
    ];

    /**
     * Контрагент
     * @return BelongsTo
     */
    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    /**
     * Адрес
     * @return BelongsTo
     */
    public function fullContractor()
    {
        return $this->contractor()->with('address');
    }

    /**
     * Список адресов
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function addresses()
    {
        return $this->morphToMany(FiasAddress::class, 'addressable');
    }

}
