<?php

namespace App\src\Services;

use App\src\Models\ContractorTos;
use App\src\Repositories\ContractorTosRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ContractorTosService
{
    protected $contractorTosRepository;

    /**
     * ContractorTosService constructor.
     * @param ContractorTosRepository $contractorTosRepository
     */
    public function __construct(ContractorTosRepository $contractorTosRepository)
    {
        $this->contractorTosRepository = $contractorTosRepository;
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

}
