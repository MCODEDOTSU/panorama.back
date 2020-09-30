<?php

namespace App\src\Services;

use App\src\Repositories\FiasAddressRepository;
use Illuminate\Support\Facades\Log;

class FiasAddressService
{
    protected $addressRepository;

    /**
     * AddressService constructor.
     * @param $addressRepository
     */
    public function __construct(FiasAddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Найти адрес в базе по ФИАС ИД или создать новый
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function findOrCreate($data)
    {
        $address = $this->addressRepository->getAddressByFlat($data['fias_id'], $data['flat']);
        return (!empty($address) ? $address : $this->create($data));
    }

    /**
     * Создать адрес
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function create($data)
    {
        return $this->addressRepository->create($data);
    }


}
