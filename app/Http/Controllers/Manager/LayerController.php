<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use App\src\Services\Manager\LayerService;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return ResponseFactory|Response
     */
    public function getAll()
    {
        try {
            return response($this->layerService->getAll(), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить все доступные для контрагента слои
     * @return ResponseFactory|Response
     */
    public function getAllToContractor()
    {
        try {
            return response($this->layerService->getAllToContractor(), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить слой по ИД
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function getById(int $id)
    {
        try {
            return response($this->layerService->getById($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Обновить слой.
     * @param int $id
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function update(int $id, Request $request)
    {
        try {
            return response($this->layerService->update($id, $request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Создать слой.
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->layerService->create($request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить слой.
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function delete(int $id)
    {
        try {
            return response($this->layerService->delete($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Загрузка икноки на сервер
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function uploadIcon(Request $request)
    {

        try {
            return response($this->layerService->uploadIcon($request->file('file')), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }
}
