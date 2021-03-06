<?php

namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use App\src\Services\Manager\ElementService;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ElementController
 * @package App\Http\Controllers\Manager
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
     * Получить все элементы слоя.
     * @param $layerId
     * @return ResponseFactory|Response
     */
    public function getAll($layerId)
    {
        try {
            return response($this->elementService->getAll($layerId), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить элементы слоя (с пагинацией).
     * @param $layerId
     * @param $limit
     * @param $page
     * @return ResponseFactory|Response
     */
    public function getAllLimit($layerId, $limit, $page)
    {
        try {
            return response($this->elementService->getAllLimit($layerId, $limit, $page), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить количество элементов слоя.
     * @param $layerId
     * @return ResponseFactory|Response
     */
    public function getCount($layerId)
    {
        try {
            return response($this->elementService->getCount($layerId), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить элементы по поиску (с пагинацией).
     * @param $search
     * @param $limit
     * @param $page
     * @return ResponseFactory|Response
     */
    public function getSearchLimit($search, $limit, $page)
    {
        try {
            return response($this->elementService->getSearchLimit($search, $limit, $page), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить количество элементов по поиску.
     * @param $search
     * @return ResponseFactory|Response
     */
    public function getSearchCount($search)
    {
        try {
            return response($this->elementService->getSearchCount($search), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить элемент по ИД.
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function getById(int $id)
    {
        try {
            return response($this->elementService->getById($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Создать элемент.
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->elementService->create($request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Обновить элемент.
     * @param int $id
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function update(int $id, Request $request)
    {
        try {
            return response($this->elementService->update($id, $request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить элемент.
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function delete(int $id)
    {
        try {
            return response($this->elementService->delete($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить несколько элементов.
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function deleteSome(Request $request)
    {
        try {
            return response($this->elementService->deleteSome($request->elements, $request->layer_id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Получить граф элемента
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function getNext(int $id)
    {
        try {
            return response($this->elementService->getNext($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

}
