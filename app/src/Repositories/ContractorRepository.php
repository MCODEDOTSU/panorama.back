<?php

namespace App\src\Repositories;

use App\src\Models\Contractor;
use Illuminate\Support\Collection;

class ContractorRepository
{
    protected $contractor;

    /**
     * ContractorRepository constructor.
     * @param $contractor
     */
    public function __construct(Contractor $contractor)
    {
        $this->contractor = $contractor;
    }

    /**
     * @param $id
     * @return Contractor
     * Контрагент по ИД
     */
    public function getById($id): Contractor
    {
        return $this->contractor
            ->with('modules')
            ->with('users')
            ->with('address')
            ->find($id);
    }

    /**
     * @return Collection
     * Все контрагенты
     */
    public function getAll(): Collection
    {
        return $this->contractor
            ->with('modules')
            ->with('users')
            ->with('address')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * @param $data
     * @return Contractor
     * Создать контрагента
     */
    public function create($data): Contractor
    {
        return $this->contractor->create($data);
    }

    /**
     * @param Contractor $contractor
     * @param $data
     * @return Contractor
     * Обновить инфу о контрагенте
     */
    public function update(Contractor $contractor, $data)
    {
        $contractor->name = $data->name;
        $contractor->full_name = $data->full_name;
        $contractor->inn = $data->inn;
        $contractor->kpp = $data->kpp;
        if (!empty($data->address_id)) {
            $contractor->address_id = $data->address_id;
        }
        $contractor->logo = $data->logo;
        $contractor->save();
        return $contractor;
    }

    /**
     * Удалить контрагента.
     * @param $id
     * @return array
     */
    public function delete(int $id)
    {
        $record = $this->contractor::find($id);
        $record->delete();
        return ['id' => $id];
    }

    /**
     * Привязать модуль к контрагенту
     * @param $contractorId
     * @param $moduleId
     * @return mixed
     */
    public function attachModule($contractorId, $moduleId)
    {
        $contractor = $this->getById($contractorId);
        $contractor->modules()->attach($moduleId);
        return $this->getById($contractorId);
    }

    /**
     * Отвязать модуль от контрагента
     * @param $contractorId
     * @param $moduleId
     * @return mixed
     */
    public function detachModule($contractorId, $moduleId)
    {
        $contractor = $this->getById($contractorId);
        $contractor->modules()->detach($moduleId);
        return $this->getById($contractorId);
    }

}
