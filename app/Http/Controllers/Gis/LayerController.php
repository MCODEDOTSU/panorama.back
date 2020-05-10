<?php

namespace App\Http\Controllers\Gis;
use App\Http\Controllers\Controller;
use App\src\Services\Gis\LayerService;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить несколько слоёв
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function getFewById(Request $request)
    {
        try {
            return response($this->layerService->getFewById($request->layers), 200);
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

}
