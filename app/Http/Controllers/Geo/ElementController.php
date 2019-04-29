<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\src\Services\Geo\ElementService;
use Illuminate\Http\Request;

/**
 * Class ElementController
 * @package App\Http\Controllers
 */
class ElementController extends Controller
{
    protected $elementService;

    /**
     * ElementController constructor.
     * @param $elementService
     */
    public function __construct(ElementService $elementService)
    {
        $this->elementService = $elementService;
    }

    /**
     * Получить элементы.
     * @param $layerId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAllByLayer($layerId)
    {
        try {
            return response($this->elementService->getElementsByLayer($layerId), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Получить элемент по ИД.
     * @param $elementId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getById($elementId)
    {
        try {
            return response($this->elementService->getElementById($elementId), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Поиск элемента по названию.
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * Поиск элементов по названию
     */
    public function searchByTitle(Request $request)
    {
        try {
            return response($this->elementService->searchByTitle($request->title), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Поиск элемента по адресу.
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * Поиск элементов по адресу
     */
    public function searchByAddress(Request $request)
    {
        try {
            return response($this->elementService->searchByAddress($request->address), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Создать новый элемент.
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->elementService->create([
                'layer_id' => $request['layer_id'],
                'title' => $request['title'],
                'description' => $request['description'],
            ]), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Сохранить изменения в элементе.
     * @param $elementId
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update($elementId, Request $request)
    {
        try {
            return response($this->elementService->update($elementId, [
                'title' => $request['title'],
                'description' => $request['description']
            ]), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Удалить элемент.
     * @param $elementId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete($elementId)
    {
        try {
            return response($this->elementService->delete($elementId), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }
}

