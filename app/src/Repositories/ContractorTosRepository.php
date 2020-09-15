<?php

namespace App\src\Repositories;

use App\src\Models\ContractorTos;
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
            ->with('contractor')
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
            ->with('contractor')
            ->find($id);
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
}
