<?php

namespace App\src\Services\Info;


use App\src\Models\Address;
use App\src\Repositories\Info\AddressRepository;

class AddressService
{
    protected $addressRepository;

    /**
     * AddressService constructor.
     * @param $addressRepository
     */
    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param $data
     * @return Address
     * Создать адрес
     */
    public function create($data)
    {
        return $this->addressRepository->create([
            'index' => isset($data['index']) ? $data['index'] : '414000',
            'region' => isset($data['region']) ? $data['region'] : '30',
            'city' => isset($data['city']) ? $data['city'] : 'г. Астрахань',
            'street' => isset($data['street']) ? $data['street'] : '',
            'build' => isset($data['build']) ? $data['build'] : '',
        ]);
    }

    public function update($addressId, $data)
    {
        return $this->addressRepository->update($addressId, [
            'index' => isset($data['index']) ? $data['index'] : '414000',
            'region' => isset($data['region']) ? $data['region'] : '30',
            'city' => isset($data['city']) ? $data['city'] : 'г. Астрахань',
            'street' => isset($data['street']) ? $data['street'] : '',
            'build' => isset($data['build']) ? $data['build'] : '',
        ]);
    }


}
