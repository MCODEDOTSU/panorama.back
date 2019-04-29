<?php

namespace App\Http\Controllers\Gis;
use App\Http\Controllers\Controller;
use App\src\Services\Gis\LayerCompositionService;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Class LayerCompositionController
 * @package App\Http\Controllers\Gis
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
     * Список состава слоев.
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function getAll()
    {
        try {
            return response($this->layerCompositionService->getAll(), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Список состава слоев для контрагента.
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function getAllToContractor()
    {
        try {
            return response($this->layerCompositionService->getAllToContractor(), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

}