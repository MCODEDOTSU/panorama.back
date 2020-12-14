<?php

namespace App\Http\Controllers;
use App\src\Models\ContractorTos;
use App\src\Models\FiasAddress;
use App\src\Services\ContractorTosService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

/**
 * Class ContractorTosController
 * @package App\Http\Controllers
 */
class ContractorTosController extends Controller
{
    protected $contractorTosService;

    /**
     * ContractorTosController constructor.
     * @param $contractorTosService
     */
    public function __construct(ContractorTosService $contractorTosService)
    {
        $this->contractorTosService = $contractorTosService;
    }

    /**
     * @return ResponseFactory|Response
     */
    public function getAll()
    {
        try {
            return response($this->contractorTosService->getAll(), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить по ИД
     * @param $id
     * @return ResponseFactory|Response
     */
    public function getById($id)
    {
        try {
            return response($this->contractorTosService->getById($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить по Адресу, входящему в список адресов ТОС
     * @param string $fiasId
     * @return ResponseFactory|Response
     */
    public function getByAddress(string $fiasId)
    {
        try {
            return response($this->contractorTosService->getByAddress($fiasId), 200);
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
            return response($this->contractorTosService->create($request), 200);
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
            return response($this->contractorTosService->update($id, $request), 200);
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
            return response($this->contractorTosService->delete($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Добавить адрес в список адресов для ТОС
     * @param ContractorTos $tos
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function addAddress(ContractorTos $tos, Request $request)
    {
        try {
            return response($this->contractorTosService->addAddress($tos, $request->address), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить адрес из списка адресов ТОС
     * @param ContractorTos $tos
     * @param FiasAddress $address
     * @return ResponseFactory|Response
     */
    public function deleteAddress(ContractorTos $tos, FiasAddress $address)
    {
        try {
            return response($this->contractorTosService->deleteAddress($tos, $address), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

}
