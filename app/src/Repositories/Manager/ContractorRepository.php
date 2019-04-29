<?php

namespace App\src\Repositories\Manager;

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
            ->get();
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
        $contractor->save();
        return $contractor;
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
        return $contractor;
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
        return $contractor;
    }

}
