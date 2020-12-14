<?php

namespace App\src\Repositories;

use App\src\Models\ContractorTos;
use App\src\Models\FiasAddress;
use Illuminate\Support\Collection;

class ContractorTosRepository
{
    protected $contractorTos;

    /**
     * ContractorTosRepository constructor.
     * @param ContractorTos $contractorTos
     */
    public function __construct(ContractorTos $contractorTos)
    {
        $this->contractorTos = $contractorTos;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->contractorTos
            ->with('fullContractor')
            ->with('addresses')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * @param $id
     * @return ContractorTos
     */
    public function getById($id): ContractorTos
    {
        return $this->contractorTos
            ->with('fullContractor')
            ->with('addresses')
            ->find($id);
    }

    /**
     * @param string $fiasId
     * @return ContractorTos
     */
    public function getByAddress(string $fiasId): ContractorTos
    {
        return $this->contractorTos
            ->with('fullContractor')
            ->whereHas('addresses', function ($query) use($fiasId) {
                $query->where('fias_id', $fiasId);
            })
            ->first();
    }

    /**
     * @param $data
     * @return ContractorTos
     */
    public function create($data): ContractorTos
    {
        return $this->contractorTos->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data): ContractorTos
    {
        $record = $this->contractorTos->find($id);
        $record->contractor_id = $data->contractor_id;
        $record->save();
        return $record;
    }

    /**
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        $record = $this->contractorTos::find($id);
        $record->delete();
        return ['id' => $id];
    }

    /**
     * Добавить адрес в список адресов для ТОС
     * @param ContractorTos $tos
     * @param FiasAddress $address
     * @return FiasAddress
     */
    public function addAddress(ContractorTos $tos, FiasAddress $address): FiasAddress
    {
        $tos->addresses()->save($address);
        return $address;
    }

    /**
     * Удалить адрес из списка адресов ТОС
     * @param ContractorTos $tos
     * @param FiasAddress $address
     * @return FiasAddress
     */
    public function deleteAddress(ContractorTos $tos, FiasAddress $address): FiasAddress
    {
        $tos->addresses()->detach([$address->id]);
        return $address;
    }
}
