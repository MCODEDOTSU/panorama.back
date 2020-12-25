<?php

namespace App\Http\Controllers;
use App\src\Models\History;
use App\src\Models\Person;
use App\src\Repositories\HistoryRepository;
use App\src\Services\PersonService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Auth;

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
     * Получить список всех ФЛ
     *
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
     * Получить ФЛ по ИД
     *
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
     * Создать ФЛ
     *
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
     * Изменить ФЛ
     *
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
     * Удалить ФЛ
     *
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

    /**
     * Загрузка фотографию на сервер
     *
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function uploadPhoto(Request $request)
    {
        try {
            return response($this->personService->uploadPhoto($request->file('file')), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Добавить запись в историю
     *
     * @param Person $person
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function createHistory(Person $person, Request $request)
    {
        try {
            return response($this->personService->createHistory($person, $request->text), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Изменить запись в истории
     *
     * @param Person $person
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function updateHistory(Person $person, Request $request)
    {
        try {
            return response($this->personService->updateHistory($person, $request->id, $request->text), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить запись из истории
     *
     * @param Person $person
     * @param History $history
     * @return History
     */
    public function deleteHistory(Person $person, History $history)
    {
        try {
            return response($this->personService->deleteHistory($person, $history), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Получить именинников
     *
     * @return ResponseFactory|Response
     */
    public function birthday()
    {
        try {
            return response($this->personService->birthday(), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

}
