<?php

namespace App\Http\Controllers\Info;


use App\src\Services\Info\PolygonService;
use Illuminate\Http\Request;

class PolygonController
{
    protected $pointService;

    /**
     * PointController constructor.
     * @param $pointService
     */
    public function __construct(PolygonService $pointService)
    {
        $this->pointService = $pointService;
    }

    public function update(Request $request)
    {
        try {
            return response($this->pointService->update($request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }


    public function create($layerId, Request $request)
    {
        try {
            return response($this->pointService->create($layerId, $request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }


    public function delete($id)
    {
        try {
            return response($this->pointService->delete($id), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }

    public function singleCreate(Request $request)
    {
        try {
            return response($this->pointService->singleCreate($request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 400);
        }
    }


}
