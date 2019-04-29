<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use App\src\Services\Manager\GeometryService\GeometryService;
use Illuminate\Http\Request;

/**
 * Class GeometryController
 * @package App\Http\Controllers\Manager
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
     * Получить все геоэлементы.
     * @param int $elementId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAll(int $elementId)
    {
        try {
            return response($this->geometryService->getAll($elementId), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Обновить геоэлемент.
     * @param string $type
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(string $type, int $id, Request $request)
    {
        try {
            return response($this->geometryService->update($id, $request, $type), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Создать геоэлемент.
     * @param string $type
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(string $type, Request $request)
    {
        try {
            return response($this->geometryService->create($request, $type), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить геоэлемент.
     * @param string $type
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete(string $type, int $id)
    {
        try {
            return response($this->geometryService->delete($id, $type), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }
}