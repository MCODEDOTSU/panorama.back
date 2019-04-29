<?php

namespace App\Http\Controllers;


use App\src\Services\Info\ModuleService;

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
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * Получить модули пользователя
     */
    public function getModules()
    {
        return response($this->moduleService->getModules(), 200);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * Получить весь список модулей
     */
    public function getAllModules()
    {
        return response($this->moduleService->getAllModules(), 200);
    }

}
