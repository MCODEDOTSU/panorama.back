<?php

namespace App\Http\Controllers;
use App\src\Services\PersonService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

/**
 * Class PersonController
 * @package App\Http\Controllers\Manager
 */
class PersonController extends Controller
{
    protected $personService;

    /**
     * PersonController constructor.
     * @param $personService
     */
    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    /**
     * Получить список всех ФЛ.
     * @return ResponseFactory|Response
     */
    public function getAll()
    {
        try {
            return response($this->personService->getAll(), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить ФЛ по ИД.
     * @param $id
     * @return ResponseFactory|Response
     */
    public function getById($id)
    {
        try {
            return response($this->personService->getById($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Создать ФЛ.
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->personService->create($request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Изменить ФЛ.
     * @param int $id
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function update(int $id, Request $request)
    {
        try {
            return response($this->personService->update($id, $request), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить ФЛ.
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function delete(int $id)
    {
        try {
            return response($this->personService->delete($id), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

}
