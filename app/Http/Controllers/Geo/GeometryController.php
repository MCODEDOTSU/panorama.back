<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\src\Services\Geo\GeometryService\GeometryService;
use Illuminate\Http\Request;

/**
 * Class GeometryController
 * @package App\Http\Controllers
 */
class GeometryController extends Controller
{
    protected $geometryService;

    /**
     * GeometryController constructor.
     * @param $geometryService
     */
    public function __construct(GeometryService $geometryService)
    {
        $this->geometryService = $geometryService;
    }

    /**
     * Обновить геометрию
     * @param $geometryId
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update($geometryId, Request $request)
    {
        try {
            if(isset($request['geom'])) {
                return response($this->geometryService->updateGeometry($geometryId, $request['geom'], $request['type']), 200);
            } else {
                return response($this->geometryService->update($geometryId, [
                    'title' => $request['title'],
                    'description' => $request['description'],
                ], $request['type']), 200);
            }
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Создать новую геометрию слоя
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->geometryService->create([
                'title' => $request['title'],
                'description' => $request['description'],
                'geom' => $request['geom'],
                'element_id' => $request['element_id'],
                'layer_composition_id' => $request['layer_composition_id']
            ], $request['type']), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    public function delete($type, $geometryId)
    {
        try {
            return response($this->geometryService->delete($geometryId, $type), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

}