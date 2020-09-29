<?php

namespace App\src\Repositories;

use App\src\Models\FiasAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FiasAddressRepository
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

    /**
     * Создать новый адрес в базе
     * @param $data
     * @return FiasAddress
     */
    public function create($data): FiasAddress
    {
        return $this->address->create($data);
    }

}
