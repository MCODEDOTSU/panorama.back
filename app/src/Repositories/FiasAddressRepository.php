<?php

namespace App\src\Repositories;

use App\src\Models\FiasAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FiasAddressRepository extends AbstractRepository
{
    protected $address;

    /**
     * AddressRepository constructor.
     * @param $address
     */
    public function __construct(FiasAddress $address)
    {
        $this->address = $address;
    }

    /**
     * Получить адрес по ФИАС ИД
     * @param string $fiasId
     * @return mixed
     */
    public function getByFiasId(string $fiasId)
    {
        return $this->address->where('fias_id', $fiasId)->first();
    }

}
