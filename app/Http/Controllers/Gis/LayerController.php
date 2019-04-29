<?php

namespace App\Http\Controllers\Gis;
use App\Http\Controllers\Controller;
use App\src\Services\Gis\LayerService;

/**
 * Class LayerController
 * @package App\Http\Controllers\Gis
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
     * Получить все слои
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

}