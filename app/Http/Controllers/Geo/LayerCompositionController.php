<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\src\Services\Geo\LayerCompositionService;

/**
 * Class LayerCompositionController
 * @package App\Http\Controllers\Geo
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
     * Получить композиции.
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAll()
    {
        try {
            return response($this->layerCompositionService->getAll(), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

}
