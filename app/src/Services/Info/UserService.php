<?php

namespace App\src\Services\Info;

use App\src\Services\MailServices\UserMailService;
use App\src\Repositories\Info\UserRepository;

class UserService
{
    protected $userRepository;
    protected $mailService;

    /**
     * UserService constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository, UserMailService $mailService)
    {
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
    }

    /**
     * Получить пользователей для контрагента
     * @param $contractorId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getAllByContractor($contractorId)
    {
        return $this->userRepository->getAllByContractor($contractorId);
    }

    /**
     * @param $data
     * @return \App\src\Models\User
     * Обновить пользователя
     */
    public function update($data)
    {
        return $this->userRepository->update(
            $this->userRepository->getById($data->id),
            $data
        );
    }

    /**
     * @param $data
     * @return \App\src\Models\User
     * Создать пользователя
     */
    public function create($data)
    {
        $data->name = $data->email;
        return $this->userRepository->create($data);
    }

    /**
     * @param $id
     * @return array Удалить пользователя
     * Удалить пользователя
     */
    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    /**
     * Запрос на регистрацию пользователя
     * @param $data
     * @return \App\src\Models\User
     */
    public function register($data)
    {
        $this->mailService->send($message);
        return true;
    }


}
