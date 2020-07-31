<?php

namespace App\src\Services\Info;

use App\src\Models\Module;
use App\src\Repositories\ContractorRepository;
use App\src\Repositories\Info\ModuleRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
     * @return Module[]|Builder[]|Collection
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
