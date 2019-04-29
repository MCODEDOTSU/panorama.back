<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use App\src\Services\Manager\LayerService;
use Illuminate\Http\Request;

/**
 * Class LayerController
 * @package App\Http\Controllers\Manager
 */
class LayerController extends Controller
{
    protected $layerService;

    /**
     * LayerController constructor.
     * @param $layerService
     */
    public function __construct(LayerService $layerService)
    {
        $this->layerService = $layerService;
    }

    /**
     * Получить все слои.
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAll()
    {
        try {
            return response($this->layerService->getAll(), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить все доступные для контрагента слои
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAllToContractor()
    {
        try {
            return response($this->layerService->getAllToContractor(), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить слой по ИД
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getById(int $id)
    {
        try {
            return response($this->layerService->getById($id), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Обновить слой.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        try {
            return response($this->layerService->update($id, $request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Создать слой.
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->layerService->create($request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить слой.
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        try {
            return response($this->layerService->delete($id), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }
}