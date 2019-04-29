<?php

namespace App\Http\Controllers;

use App\src\Models\Contractor;
use App\src\Services\Info\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{
    protected $userService;

    /**
     * UserController constructor.
     * @param $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     * Получить пользователя с контрагентом и модулями
     */
    public function getUser()
    {
        // Пользователь
        $authedUser = Auth::user();

        // Контрагент
        $authedUser->contractor = $authedUser->contractor()->first();

        // Модули
        $contractor = Contractor::find($authedUser->contractor_id);
        if($contractor) {
            $authedUser->modules = $contractor->modules()->get();
        }


        return $authedUser;
    }

    /**
     * Получить пользователей для контрагента
     * @param $contractorId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAllByContractor($contractorId)
    {
        try {
            return response($this->userService->getAllByContractor($contractorId), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * Обновить пользователя
     */
    public function update(Request $request)
    {
        try {
            return response($this->userService->update($request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Создать нового пользователя
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            return response($this->userService->create($request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Удалить пользователя
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete($id)
    {
        if($id == 1) {
            return response(['error' => 'Нельзя удалять Главного Администратора системы!'], 500);
        }
        try {
            return response($this->userService->delete($id), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Запрос на регистрацию пользователя
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            return response($this->userService->register($request), 200);
        } catch (\Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }


}
