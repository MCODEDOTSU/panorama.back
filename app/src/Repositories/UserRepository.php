<?php

namespace App\src\Repositories;

use App\src\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class UserRepository
{
    protected $user;

    /**
     * UserRepository constructor.
     * @param $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $email
     * @return mixed
     * Получить пользователя по email
     */
    public function getUserByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    /**
     * Получить пользователей для контрагента
     * @param $contractorId
     * @return ResponseFactory|Response
     */
    public function getAllByContractor($contractorId)
    {
        return $this->user->where('contractor_id', $contractorId)->get();
    }

    /**
     * @param $request
     * @return User
     * Создать пользователя
     */
    public function create($request)
    {
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'post' => $request->post,
            'photo' => $request->photo,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'contractor_id' => $request->contractor_id,
        ];

        if (!empty($request->person_id)) {
            $userData['person_id'] = $request->person_id;
        }

        $user = new User($userData);
        $user->save();

        return $user;
    }

    /**
     * @param User $user
     * @param $data
     * @return User
     * Обновить пользователя
     */
    public function update(User $user, $data)
    {
        $user->name = $data['email'];
        $user->email = $data['email'];
        $user->post = $data['post'];
        $user->photo = $data['photo'];
        $user->role = $data['role'];

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        if (!empty($data['person_id'])) {
            $user->person_id = $data['person_id'];
        }

        $user->save();

        return $user;
    }

    /**
     * @param int $id
     * @return mixed
     * Получить пользователя по ИД
     */
    public function getById(int $id)
    {
        return $this->user->find($id);
    }

    /**
     * Удалить пользователя
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        $record = $this->user->find($id);
        $record->delete();
        return ['id' => $id];
    }

}
