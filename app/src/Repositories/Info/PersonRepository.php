<?php

namespace App\src\Repositories\Info;

use App\src\Models\Person;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class PersonRepository
{
    protected $person;

    /**
     * PersonRepository constructor.
     * @param $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * @param $request
     * @return Person
     * Создать физическое лицо
     */
    public function create($request)
    {
        $person = new Person([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'date_of_birth' => $request->date_of_birth,
            'address_id' => $request->address_id,
            'phones' => $request->phones,
            'note' => $request->note,
        ]);

        $person->save();

        return $person;
    }

    /**
     * @param $data
     * @param $person_id
     * @return Person
     * Обновить физическое лицо
     */
    public function update($data, $person_id)
    {
        $person = $this->module->find($person_id);

        $person->firstname = $data['firstname'];
        $person->lastname = $data['lastname'];
        $person->middlename = $data['middlename'];
        $person->date_of_birth = $data['date_of_birth'];
        $person->address_id = $data['address_id'];
        $person->phones = $data['phones'];
        $person->note = $data['note'];
        $person->save();

        return $person;
    }

    /**
     * @param int $id
     * @return mixed
     * Получить пользователя по ИД
     */
    public function getById(int $id)
    {
        return $this->person->find($id);
    }

    /**
     * Удалить пользователя
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        $record = $this->person->find($id);
        $record->delete();
        return ['id' => $id];
    }

}
