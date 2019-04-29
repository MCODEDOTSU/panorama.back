<?php

namespace App\Http\Controllers\Gis;
use App\Http\Controllers\Controller;
use App\src\Services\Gis\GeometryService\GeometryService;
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
     * Вся геометрия элемента
     * @param $elementId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getByElementId($elementId)
    {
        try {
            return response($this->geometryService->getByElementId($elementId), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Получить геометрию элементов
     * @param $layerId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getByLayerId($layerId)
    {
        try {
            return response($this->geometryService->getByLayerId($layerId), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Создать новую геометрию
     * @param string $type
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(string $type, Request $request)
    {
        try {
            return response($this->geometryService->create([
                'title' => $request->title,
                'description' => $request->description,
                'element_id' => $request->element_id,
                'layer_composition_id' => $request->layer_composition_id,
                'geom' => $request->geom,
            ], $type), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Обновить свойста геометрии
     * @param string $type
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(string $type, int $id, Request $request)
    {
        try {
            return response($this->geometryService->update($id, [
                'title' => $request->title,
                'description' => $request->description,
                'geom' => $request->geom,
            ], $type), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Удалить геометрию
     * @param string $type
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete(string $type, int $id)
    {
        try {
            return response($this->geometryService->delete($id, $type), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

}