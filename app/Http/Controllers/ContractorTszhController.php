<?php

namespace App\Http\Controllers;
use App\src\Services\ContractorTszhService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

/**
 * Class ContractorTszhController
 * @package App\Http\Controllers
 */
class ContractorTszhController extends Controller
{
    protected $contractorTszhService;

    /**
     * ContractorTszhController constructor.
     * @param $contractorTszhService
     */
    public function __construct(ContractorTszhService $contractorTszhService)
    {
        $this->contractorTszhService = $contractorTszhService;
    }

    /**
     * @return ResponseFactory|Response
     */
    public function getAll()
    {
        try {
            return response($this->contractorTszhService->getAll(), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->contractorTszhService->create($request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param int $id
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function update(int $id, Request $request)
    {
        try {
            return response($this->contractorTszhService->update($id, $request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function delete(int $id)
    {
        try {
            return response($this->contractorTszhService->delete($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Поиск ТСЖ по адресу
     * @param string $fiasId
     * @return ResponseFactory|Response
     */
    public function getByAddress(string $fiasId)
    {
        try {
            return response($this->contractorTszhService->getByAddress($fiasId), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

}
