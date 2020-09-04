<?php

namespace App\src\Services;

use App\src\Models\User;
use App\src\Repositories\ContractorRepository;
use App\src\Services\MailServices\UserMailService;
use App\src\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;
use Image;

class UserService
{
    protected $userRepository;
    protected $mailService;
    protected $contractorRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param UserMailService $mailService
     * @param ContractorRepository $contractorRepository
     */
    public function __construct(UserRepository $userRepository, UserMailService $mailService, ContractorRepository $contractorRepository)
    {
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
        $this->contractorRepository = $contractorRepository;
    }

    /**
     * Получить пользователей для контрагента
     * @param $contractorId
     * @return User[]|Builder[]|Collection
     */
    public function getAllByContractor($contractorId)
    {
        // Определить дочерних контрагентов, пользователи которых тоже включены
        $childContractors =  $this->contractorRepository->getChildrenContractors($contractorId)->pluck('id');
        $allContractors = $childContractors->prepend((int)$contractorId);

        return $this->userRepository->getAllByContractor($allContractors);
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
