<?php

namespace App\Http\Controllers;
use App\src\Services\ContractorService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

/**
 * Class ContractorController
 * @package App\Http\Controllers\Manager
 */
class ContractorController extends Controller
{
    protected $contractorService;

    /**
     * ContractorController constructor.
     * @param $contractorService
     */
    public function __construct(ContractorService $contractorService)
    {
        $this->contractorService = $contractorService;
    }

    /**
     * @return ResponseFactory|Response
     * Получить всех контрагентов
     */
    public function getAll()
    {
        try {
            return response($this->contractorService->getAll(), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить контрагента по ИД
     * @param $id
     * @return ResponseFactory|Response
     */
    public function getById($id)
    {
        try {
            return response($this->contractorService->getById($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     * Обновить информацию о контрагенте
     */
    public function create(Request $request)
    {
        try {
            return response($this->contractorService->create($request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     * Обновить информацию о контрагенте
     */
    public function update(Request $request)
    {
        try {
            return response($this->contractorService->update($request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить контрагента.
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function delete(int $id)
    {
        try {
            return response($this->contractorService->delete($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param $contractorId
     * @param $moduleId
     * Привязать модуль к контрагенту
     * @return ResponseFactory|Response
     */
    public function attachModule($contractorId, $moduleId)
    {
        try {
            return response($this->contractorService->attachModule($contractorId, $moduleId), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param $contractorId
     * @param $moduleId
     * @return ResponseFactory|Response
     * Отвязать модуль от контрагента
     */
    public function detachModule($contractorId, $moduleId)
    {
        try {
            return response($this->contractorService->detachModule($contractorId, $moduleId), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Загрузка логотип контрагента
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function uploadLogo(Request $request)
    {
        try {
            return response($this->contractorService->uploadLogo($request->file('file')), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    public function detachParentContractor(Request $contractor)
    {
        try {
            return response($this->contractorService->detachParentContractor($contractor), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

}
