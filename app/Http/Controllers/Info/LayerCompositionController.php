<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use App\src\Services\Geo\LayerCompositionService;
use Illuminate\Http\Request;

class LayerCompositionController extends Controller
{

    protected $layerCompositionService;

    public function __construct(LayerCompositionService $layerCompositionService)
    {
        $this->layerCompositionService = $layerCompositionService;
    }

    /**
     * Получить все слои
     * @param $layerId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getLayerCompositions($layerId)
    {
        try {
            return response($this->layerCompositionService->getLayerCompositions($layerId), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

}