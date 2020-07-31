<?php

namespace App\src\Services;

use App\src\Models\Person;
use App\src\Repositories\PersonRepository;
use App\src\Services\AddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Class PersonService
 * @package App\src\Services
 */
class PersonService
{
    protected $personRepository;
    protected $addressService;

    /**
     * PersonService constructor.
     * @param PersonRepository $personRepository
     * @param AddressService $addressService
     */
    public function __construct(PersonRepository $personRepository,
                                AddressService $addressService)
    {
        $this->personRepository = $personRepository;
        $this->addressService = $addressService;
    }

    /**
     * Получить всех ФЛ.
     * @return Collection
     */
    public function getAll()
    {
        return $this->personRepository->getAll();
    }

    /**
     * Получить ФЛ по ИД.
     * @param $id
     * @return Person Получить всех контрагентов
     */
    public function getById($id)
    {
        return $this->personRepository->getById($id);
    }

    /**
     * Создать ФЛ.
     * @param Request $data
     * @return Person
     */
    public function create(Request $data)
    {
        if (!empty($data->address)) {
            $address = $this->addressService->create([
                'city' => $data->address['city'],
                'street' => $data->address['street'],
                'build' => $data->address['build'],
            ]);
            $data->address_id = $address->id;
        }

        return $this->personRepository->create($data);
    }

    /**
     * Обновить ФЛ.
     * @param int $id
     * @param Request $data
     * @return Person
     */
    public function update(int $id, Request $data)
    {
        if (!empty($data->address)) {
            if (empty($data->address['id']) || $data->address['id'] == 0) {
                $address = $this->addressService->create([
                    'city' => $data->address['city'],
                    'street' => $data->address['street'],
                    'build' => $data->address['build'],
                ]);
                $data->address_id = $address->id;
            } else {
                $this->addressService->update($data->address['id'], [
                    'city' => $data->address['city'],
                    'street' => $data->address['street'],
                    'build' => $data->address['build'],
                ]);
            }
        }

        return $this->personRepository->update($id, $data);
    }

    /**
     * Удалить контрагента.
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->personRepository->delete($id);
    }

}
