<?php

namespace App\src\Repositories;

use App\src\Models\History;
use App\src\Models\Person;
use Illuminate\Support\Collection;

/**
 * Class PersonRepository
 * @package App\src\Repositories
 */
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
     * Все ФЛ
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->person
            ->with('users')
            ->with('address')
            ->with('history.create_user')
            ->orderBy('lastname', 'asc')
            ->orderBy('firstname', 'asc')
            ->orderBy('middlename', 'asc')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * ФЛ по ИД
     *
     * @param $id
     * @return Person
     */
    public function getById($id): Person
    {
        return $this->person
            ->with('users')
            ->with('address')
            ->with('history.create_user')
            ->find($id);
    }

    /**
     * Создать ФЛ
     *
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
            'post' => $data->post,
            'photo' => $data->photo,
            'passport_series' => $data->passport_series,
            'passport_number' => $data->passport_number,
            'passport_issued_by' => $data->passport_issued_by,
            'passport_issued_when' => $data->passport_issued_when,
            'passport_department_number' => $data->passport_department_number,
            'own' => $data->own,
            'status' => $data->status,
        ];

        if (!empty($data->fias_address_id)) {
            $personData['fias_address_id'] = $data->fias_address_id;
        }

        $person = $this->person->create($personData);
        return $this->getById($person->id);
    }

    /**
     * Изменить
     *
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
        if (!empty($data->fias_address_id)) {
            $person->fias_address_id = $data->fias_address_id;
        }
        $person->phones = $data->phones;
        $person->note = $data->note;
        $person->photo = $data->photo;
        $person->post = $data->post;
        $person->passport_series = $data->passport_series;
        $person->passport_number = $data->passport_number;
        $person->passport_issued_by = $data->passport_issued_by;
        $person->passport_issued_when = $data->passport_issued_when;
        $person->passport_department_number = $data->passport_department_number;
        $person->own = $data->own;
        $person->status = $data->status;

        $person->save();
        return $this->getById($id);
    }

    /**
     * Удалить ФЛ
     *
     * @param $id
     * @return array
     */
    public function delete(int $id)
    {
        $person = $this->person::find($id);
        $person->delete();
        return ['id' => $id];
    }

    /**
     * Добавить запись в историю
     *
     * @param Person $person
     * @param History $history
     * @return void
     */
    public function createHistory(Person $person, History $history)
    {
        $person->history()->save($history);
    }

    /**
     * Удалить запись из истории
     *
     * @param Person $person
     * @param History $history
     * @return void
     */
    public function deleteHistory(Person $person, $history)
    {
        $person->history()->detach([$history->id]);
    }

}
