<?php

namespace App\Http\Controllers;
use App\src\Services\RegionService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Exception;

/**
 * Class RegionController
 * @package App\Http\Controllers\Manager
 */
class RegionController extends Controller
{
    protected $regionService;

    /**
     * RegionController constructor.
     * @param $regionService
     */
    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    /**
     * Получить список регионов.
     * @return ResponseFactory|Response
     */
    public function index()
    {
        try {
            return response($this->regionService->getAll(), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

}
