<?php

namespace App\Http\Controllers\Gis;
use App\Http\Controllers\Controller;
use App\src\Services\Gis\ElementService;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * Создать новый элемент.
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->elementService->create($request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Сохранить изменения в элементе.
     * @param int $id
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function update(int $id, Request $request)
    {
        try {
            return response($this->elementService->update($id, $request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Сохранить изменения в геометрии элемента.
     * @param int $id
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function updateGeometry(int $id, Request $request)
    {
        try {
            return response($this->elementService->updateGeometry($id, $request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
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
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    /**
     * Получить все связанные элементы.
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function links(int $id)
    {
        try {
            return response($this->elementService->links($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }
}

