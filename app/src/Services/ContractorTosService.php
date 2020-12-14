<?php

namespace App\src\Services;

use App\src\Models\ContractorTos;
use App\src\Models\FiasAddress;
use App\src\Repositories\ContractorTosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\src\Services\FiasAddressService;

class ContractorTosService
{
    protected $contractorTosRepository;
    protected $addressService;

    /**
     * ContractorTosService constructor.
     * @param ContractorTosRepository $contractorTosRepository
     */
    public function __construct(
        ContractorTosRepository $contractorTosRepository,
        FiasAddressService $addressService
    )
    {
        $this->contractorTosRepository = $contractorTosRepository;
        $this->addressService = $addressService;
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        return $this->contractorTosRepository->getAll();
    }

    /**
     * @param $id
     * @return ContractorTos
     */
    public function getById($id)
    {
        return $this->contractorTosRepository->getById($id);
    }

    /**
     * @param string $fiasId
     * @return ContractorTos
     */
    public function getByAddress(string $fiasId): ContractorTos
    {
        return $this->contractorTosRepository->getByAddress($fiasId);
    }

    /**
     * @param Request $data
     * @return ContractorTos
     */
    public function create(Request $data)
    {
        $record = $this->contractorTosRepository->create([
            'contractor_id' => $data->contractor_id
        ]);
        return $this->getById($record->id);
    }

    /**
     * @param $id
     * @param Request $data
     * @return ContractorTos
     */
    public function update($id, Request $data)
    {
        $this->contractorTosRepository->update($id, [
            'contractor_id' => $data->contractor_id
        ]);
        return $this->getById($id);
    }

    /**
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->contractorTosRepository->delete($id);
    }

    /**
     * Добавить адрес в список адресов для ТОС
     * @param ContractorTos $tos
     * @param $address
     * @return FiasAddress
     */
    public function addAddress(ContractorTos $tos, $address): FiasAddress
    {
        $address = $this->addressService->findOrCreate($address);
        return $this->contractorTosRepository->addAddress($tos, $address);
    }

    /**
     * Удалить адрес из списка адресов ТОС
     * @param ContractorTos $tos
     * @param FiasAddress $address
     * @return FiasAddress
     */
    public function deleteAddress(ContractorTos $tos, FiasAddress $address): FiasAddress
    {
        return $this->contractorTosRepository->deleteAddress($tos, $address);
    }

}
