<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\src\Services\Geo\LayerService;

/**
 * Class LayerController
 * @package App\Http\Controllers
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
            return response($this->layerService->getLayers(), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Получить слои для редактивроания.
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function managerGetAll()
    {
        //try {
            return response($this->layerService->getManagerLayers(), 200);
        //} catch (\Exception $ex) {
        //    return response(['error' => $ex->getMessage()], 400);
        //}
    }

    /**
     * Получить все слои модуля.
     * @param $moduleId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAllByModule($moduleId)
    {
        try {
            return response($this->layerService->getLayersByModule($moduleId), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

}
