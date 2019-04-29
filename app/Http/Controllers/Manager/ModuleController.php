<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use App\src\Services\Manager\ModuleService;
use Illuminate\Http\Request;

/**
 * Class ModuleController
 * @package App\Http\Controllers\Manager
 */
class ModuleController extends Controller
{
    protected $moduleService;

    /**
     * ModuleController constructor.
     * @param $moduleService
     */
    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    /**
     * Получить все модули.
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAll()
    {
        try {
            return response($this->moduleService->getAll(), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Обновить модуль.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        try {
            return response($this->moduleService->update($id, $request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Создать модуль.
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->moduleService->create($request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить модуль.
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        try {
            return response($this->moduleService->delete($id), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }
}