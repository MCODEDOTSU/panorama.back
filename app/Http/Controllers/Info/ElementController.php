<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;
use App\src\Services\Info\ElementService;
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
     * Получить элементы
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

    public function update(Request $request)
    {
        try {
            return response($this->elementService->update($request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    public function create(Request $request)
    {
        try {
            return response($this->elementService->create($request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    public function delete($id)
    {
        try {
            return response($this->elementService->delete($id), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    
}
