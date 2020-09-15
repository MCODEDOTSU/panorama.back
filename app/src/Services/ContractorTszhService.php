<?php

namespace App\src\Services;

use App\src\Models\ContractorTszh;
use App\src\Repositories\ContractorTszhRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ContractorTszhService
{
    protected $contractorTszhRepository;

    /**
     * ContractorTszh constructor.
     * @param ContractorTszhRepository $contractorTszhRepository
     */
    public function __construct(ContractorTszhRepository $contractorTszhRepository)
    {
        $this->contractorTszhRepository = $contractorTszhRepository;
    }

    /**
     * @return Collection
     * Получить все ТОСы
     */
    public function getAll()
    {
        return $this->contractorTszhRepository->getAll();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->contractorTszhRepository->getById($id);
    }

    /**
     * @param Request $data
     * @return ContractorTszh
     * Создать ТОС
     */
    public function create(Request $data)
    {
        $record = $this->contractorTszhRepository->create([
            'contractor_id' => $data->contractor_id
        ]);
        return $this->getById($record->id);
    }

    /**
     * Обновить ТОС.
     * @param $id
     * @param Request $data
     * @return ContractorTszh
     */
    public function update($id, Request $data)
    {
        $this->contractorTszhRepository->update($id, [
            'contractor_id' => $data->contractor_id
        ]);
        return $this->getById($id);
    }

    /**
     * Удалить контрагента.
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->contractorTszhRepository->delete($id);
    }

}
