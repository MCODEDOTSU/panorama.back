<?php

namespace App\src\Services\Info;

use App\src\Repositories\Manager\ContractorRepository;
use App\src\Repositories\Info\ModuleRepository;
use Illuminate\Support\Facades\Auth;

class ModuleService
{
    protected $moduleRepository;
    protected $contractorRepository;

    /**
     * ModuleService constructor.
     * @param ModuleRepository $moduleRepository
     * @param ContractorRepository $contractorRepository
     */
    public function __construct(ModuleRepository $moduleRepository, ContractorRepository $contractorRepository)
    {
        $this->moduleRepository = $moduleRepository;
        $this->contractorRepository = $contractorRepository;
    }

    /**
     * @return \App\src\Models\Module[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * Получить модули пользователя
     */
    public function getModules()
    {
        $authedUser = Auth::user();

        // Контрагент
        $authedUser->contractor = $authedUser->contractor()->first();
        $contractor = $this->contractorRepository->getById($authedUser->contractor_id);

        return $this->moduleRepository->getModules($contractor->id);
    }

    /**
     * @return mixed
     * Получить все модули
     */
    public function getAllModules()
    {
        return $this->moduleRepository->getAllModules();
    }

}
