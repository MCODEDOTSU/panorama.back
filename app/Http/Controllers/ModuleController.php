<?php

namespace App\Http\Controllers;


use App\src\Services\Info\ModuleService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class ModuleController
{
    protected $moduleService;

    /**
     * ModuleController constructor.
     * @param ModuleService $moduleService
     */
    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    /**
     * @return ResponseFactory|Response
     * Получить модули пользователя
     */
    public function getModules()
    {
        return response($this->moduleService->getModules(), 200);
    }

    /**
     * @return ResponseFactory|Response
     * Получить весь список модулей
     */
    public function getAllModules()
    {
        return response($this->moduleService->getAllModules(), 200);
    }

}
