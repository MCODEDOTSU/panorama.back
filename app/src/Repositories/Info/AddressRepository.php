<?php

namespace App\src\Repositories\Info;


use App\src\Models\Address;
use Illuminate\Support\Collection;

class AddressRepository
{
    protected $address;

    /**
     * AddressRepository constructor.
     * @param $address
     */
    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @param $id
     * @return mixed
     * Найти адрес по ИД
     */
    public function getById($id): Address
    {
        return $this->address->find($id);
    }

    /**
     * @param $data
     * @return Address
     * Создать адрес
     */
    public function create($data): Address
    {
        return $this->address->create($data);
    }


    /**
     * @param $addressId
     * @param $data
     * @return Address
     * Обновить информацию об адресе
     */
    public function update($addressId, $data): Address
    {
        $record = $this->address::find($addressId);
        $record->index = $data['index'];
        $record->region = $data['region'];
        $record->city = $data['city'];
        $record->street = $data['street'];
        $record->build = $data['build'];
        $record->save();
        return $record;
    }

    public function searchByAddress($id, $address): Collection
    {
        return $this->address
            ->where('id', '=', $id)
            ->where(function ($query) use ($address) {
                $query->where('city', 'like', '%' . $address . '%')
                    ->orWhere('build', 'like', '%'.$address.'%')
                    ->orWhere('street', 'like', '%'.$address.'%');
            })
            ->get();

    }



}
