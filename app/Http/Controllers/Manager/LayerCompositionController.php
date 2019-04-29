<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use App\src\Services\Manager\LayerCompositionService;
use Illuminate\Http\Request;

/**
 * Class LayerCompositionController
 * @package App\Http\Controllers\Manager
 */
class LayerCompositionController extends Controller
{
    protected $layerCompositionService;

    /**
     * LayerCompositionController constructor.
     * @param $layerCompositionService
     */
    public function __construct(LayerCompositionService $layerCompositionService)
    {
        $this->layerCompositionService = $layerCompositionService;
    }

    /**
     * Список состава слоя.
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAll($layerId)
    {
        try {
            return response($this->layerCompositionService->getAll($layerId), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Обновить композицию.
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(int $id, Request $request)
    {
        try {
            return response($this->layerCompositionService->update($id, $request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Создать композицию слоя.
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->layerCompositionService->create($request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить композицию.
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        try {
            return response($this->layerCompositionService->delete($id), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Загрузка икноки на сервер
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function uploadIcon(Request $request)
    {

        try {
            return response($this->layerCompositionService->uploadIcon($request->file('file')), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

}