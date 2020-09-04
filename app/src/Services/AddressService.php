<?php

namespace App\src\Services;

use App\src\Models\Address;
use App\src\Repositories\AddressRepository;
use Illuminate\Support\Facades\Log;

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
    public function create($data): Address
    {
        $address = [
            'index' => isset($data['index']) ? $data['index'] : '414000',
            'district' => isset($data['district']) ? $data['district'] : '',
            'city' => isset($data['city']) ? $data['city'] : 'г. Астрахань',
            'street' => isset($data['street']) ? $data['street'] : '',
            'build' => isset($data['build']) ? $data['build'] : '',
        ];
        if (!empty($data['region_id'])) {
            $address['region_id'] = $data['region_id'];
        }
        return $this->addressRepository->create($address);
    }

    public function update($addressId, $data)
    {
        $address = [
            'index' => isset($data['index']) ? $data['index'] : '414000',
            'district' => isset($data['district']) ? $data['district'] : '',
            'city' => isset($data['city']) ? $data['city'] : 'г. Астрахань',
            'street' => isset($data['street']) ? $data['street'] : '',
            'build' => isset($data['build']) ? $data['build'] : '',
        ];
        if (!empty($data['region_id'])) {
            $address['region_id'] = $data['region_id'];
        }
        return $this->addressRepository->update($addressId, $address);
    }


}
