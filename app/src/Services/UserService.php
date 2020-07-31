<?php

namespace App\src\Services;

use App\src\Models\User;
use App\src\Services\MailServices\UserMailService;
use App\src\Repositories\UserRepository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Image;

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

    /**
     * Загрузить фотографию пользователя
     * @param $file
     * @return mixed
     */
    public function uploadPhoto($file)
    {
        $path = $file->hashName('images/users');
        list($width, $height) = getimagesize($file);
        $image = Image::make($file);

        if($width > 256 || $height > 256) {
            $image->fit(256, 256, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        Storage::put("public/$path", (string)$image->encode());
        list($width, $height) = getimagesize("storage/$path");

        return [
            'filename' => "storage/$path",
        ];
    }

}
