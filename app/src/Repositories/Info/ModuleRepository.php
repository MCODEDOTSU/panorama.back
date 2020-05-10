<?php

namespace App\src\Repositories\Info;


use App\src\Models\Module;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ModuleRepository
{
    protected $module;

    /**
     * ModuleRepository constructor.
     * @param Module $module
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * @param $contractorId
     * @return Module[]|Builder[]|\Illuminate\Database\Eloquent\Collection
     * Получить модули, привязанные к определенному контрагенту
     */
    public function getModules($contractorId)
    {
        return $this->module
            ->with('layers')
            ->whereHas('contractors', function ($query) use ($contractorId){
                $query->where('contractor_id', '=', $contractorId);
            })
            ->get();
    }

    /**
     * @return mixed
     * Получить все модули
     */
    public function getAllModules(): Collection
    {
        return $this->module->get();
    }

    /**
     * @param $id
     * @return Module
     * Получить модуль по ИД
     */
    public function getById($id): Module
    {
        return $this->module->find($id);
    }


}
