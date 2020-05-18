<?php

namespace App\src\Repositories\Info;


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
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'post' => $request->post,
            'photo' => $request->photo,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'contractor_id' => $request->contractor_id,
        ]);

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
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->middlename = $data['middlename'];
        $user->post = $data['post'];
        $user->photo = $data['photo'];
        $user->role = $data['role'];
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
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
