<?php

namespace App\src\Repositories;

use App\src\Models\Person;
use Illuminate\Support\Collection;

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
     * Все ФЛ.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->person
            ->with('users')
            ->with('address')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * ФЛ по ИД.
     * @param $id
     * @return Person
     */
    public function getById($id): Person
    {
        return $this->person
            ->with('users')
            ->with('address')
            ->find($id);
    }

    /**
     * Создать ФЛ.
     * @param $data
     * @return Person
     */
    public function create($data): Person
    {
        $personData = [
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'middlename' => $data->middlename,
            'date_of_birth' => $data->date_of_birth,
            'phones' => $data->phones,
            'note' => $data->note,
        ];

        if (!empty($data->address_id)) {
            $personData['address_id'] = $data->address_id;
        }

        $person = $this->person->create($personData);
        return $this->getById($person->id);
    }

    /**
     * Изменить
     * @param int $id
     * @param $data
     * @return Person
     */
    public function update(int $id, $data)
    {
        $person = $this->getById($id);

        $person->firstname = $data->firstname;
        $person->lastname = $data->lastname;
        $person->middlename = $data->middlename;
        $person->date_of_birth = $data->date_of_birth;
        if (!empty($data->address_id)) {
            $person->address_id = $data->address_id;
        }
        $person->phones = $data->phones;
        $person->note = $data->note;

        $person->save();
        return $this->getById($id);
    }

    /**
     * Удалить ФД.
     * @param $id
     * @return array
     */
    public function delete(int $id)
    {
        $person = $this->person::find($id);
        $person->delete();
        return ['id' => $id];
    }

}
