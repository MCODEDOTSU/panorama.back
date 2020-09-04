<?php

namespace App\src\Repositories;

use App\src\Models\Address;
use Illuminate\Support\Collection;

class AddressRepository extends AbstractRepository
{
    protected $address;

    /**
     * AddressRepository constructor.
     * @param $address
     */
    public function __construct(Address $address)
    {
        $this->address = $address;
        $this->model = $address;
    }

    /**
     * @param $id
     * @return mixed
     * Найти адрес по ИД
     */
    public function getById($id): Address
    {
        return $this->address->with('region')->find($id);
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
        $record->district = $data['district'];
        $record->city = $data['city'];
        $record->street = $data['street'];
        $record->build = $data['build'];
        if (!empty($data['region_id'])) {
            $record->region_id = $data['region_id'];
        }
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
