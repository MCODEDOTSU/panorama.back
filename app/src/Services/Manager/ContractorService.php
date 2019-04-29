<?php

namespace App\src\Services\Manager;

use App\src\Repositories\Manager\ContractorRepository;
use App\src\Services\Info\AddressService;
use Illuminate\Http\Request;

class ContractorService
{
    protected $contractorRepository;
    protected $addressService;

    /**
     * ContractorService constructor.
     * @param ContractorRepository $contractorRepository
     * @param AddressService $addressService
     */
    public function __construct(ContractorRepository $contractorRepository,
                                AddressService $addressService)
    {
        $this->contractorRepository = $contractorRepository;
        $this->addressService = $addressService;
    }

    /**
     * @return \Illuminate\Support\Collection
     * Получить всех контрагентов
     */
    public function getAll()
    {
        return $this->contractorRepository->getAll();
    }

    /**
     * Получить контрагента по ИД.
     * @param $id
     * @return \App\src\Models\Contractor Получить всех контрагентов
     */
    public function getById($id)
    {
        return $this->contractorRepository->getById($id);
    }

    /**
     * Обновить котрагента.
     * @param Request $data
     * @return \App\src\Models\Contractor
     */
    public function update(Request $data)
    {
        $address = $this->addressService->update($data->address['id'], [
            'city' => $data->address['city'],
            'street' => $data->address['street'],
            'build' => $data->address['build'],
        ]);
        $contractorToUpdate = $this->contractorRepository->getById($data->id);
        $updatedContractor = $this->contractorRepository->update($contractorToUpdate, $data);
        $updatedContractor->address = $address;
        return $updatedContractor;
    }

    /**
     * @param Request $data
     * @return \App\src\Models\Contractor
     * Создать контрагента
     */
    public function create(Request $data)
    {
        $address = $this->addressService->create([
            'city' => $data->address['city'],
            'street' => $data->address['street'],
            'build' => $data->address['build'],
        ]);
        $newContractor = $this->contractorRepository->create([
            'name' => $data->name,
            'full_name' => $data->full_name,
            'inn' => $data->inn,
            'kpp' => $data->kpp,
            'address_id' => $address->id,
        ]);

        $newContractor->address = $address;
        $newContractor->modules = [];

        return $newContractor;
    }

    /**
     * Удалить контрагента.
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->contractorRepository->delete($id);
    }

    /**
     * Привязать модуль к контрагенту
     * @param $contractorId
     * @param $moduleId
     * @return mixed
     */
    public function attachModule($contractorId, $moduleId)
    {
        return $this->contractorRepository->attachModule($contractorId, $moduleId);
    }

    /**
     * Отвязать модуль от контрагента
     * @param $contractorId
     * @param $moduleId
     * @return mixed
     */
    public function detachModule($contractorId, $moduleId)
    {
        return $this->contractorRepository->detachModule($contractorId, $moduleId);
    }

}
