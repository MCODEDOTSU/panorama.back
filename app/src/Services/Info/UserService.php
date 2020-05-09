<?php

namespace App\src\Services\Info;

use App\src\Models\User;
use App\src\Services\MailServices\UserMailService;
use App\src\Repositories\Info\UserRepository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class UserService
{
    protected $userRepository;
    protected $mailService;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserMailService $mailService
     */
    public function __construct(UserRepository $userRepository, UserMailService $mailService)
    {
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
    }

    /**
     * Получить пользователей для контрагента
     * @param $contractorId
     * @return ResponseFactory|Response
     */
    public function getAllByContractor($contractorId)
    {
        return $this->userRepository->getAllByContractor($contractorId);
    }

    /**
     * @param $data
     * @return User
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
     * @return User
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
     * TODO: Method for the future
     * Запрос на регистрацию пользователя
     * @param $data
     * @return bool
     */
    public function register($data)
    {
        $message = "";
        $this->mailService->send($message);
        return true;
    }


}
