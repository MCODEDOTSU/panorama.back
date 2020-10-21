<?php

namespace App\src\Repositories;

use App\src\Models\ContractorTszh;
use Illuminate\Support\Collection;

class ContractorTszhRepository
{
    protected $contractorTszh;

    /**
     * ContractorTszhRepository constructor.
     * @param ContractorTszh $contractorTszh
     */
    public function __construct(ContractorTszh $contractorTszh)
    {
        $this->contractorTszh = $contractorTszh;
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->contractorTszh
            ->with('fullContractor')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * @param $id
     * @return ContractorTszh
     */
    public function getById($id): ContractorTszh
    {
        return $this->contractorTszh
            ->with('contractor')
            ->find($id);
    }

    /**
     * @param $id
     * @return ContractorTszh
     */
    public function getByAddress(string $fiasId)
    {
        return $this->contractorTszh
            ->select('contractors.*')
            ->join('contractors', 'contractors.id', '=', 'contractors_tszh.contractor_id')
            ->join('fias_address', 'fias_address.id', '=', 'contractors.fias_address_id')
            ->where('fias_address.fias_id', $fiasId)
            ->first();
    }

    /**
     * @param $data
     * @return ContractorTszh
     */
    public function create($data): ContractorTszh
    {
        return $this->contractorTszh->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data): ContractorTszh
    {
        $record = $this->contractorTszh->find($id);
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
        $record = $this->contractorTszh::find($id);
        $record->delete();
        return ['id' => $id];
    }
}
