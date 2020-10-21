<?php

namespace App\src\Services;

use App\src\Models\Person;
use App\src\Repositories\PersonRepository;
use App\src\Services\FiasAddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Image;

/**
 * Class PersonService
 * @package App\src\Services
 */
class PersonService
{
    protected $personRepository;
    protected $addressService;

    /**
     * PersonService constructor.
     * @param PersonRepository $personRepository
     * @param FiasAddressService $addressService
     */
    public function __construct(PersonRepository $personRepository,
                                FiasAddressService $addressService)
    {
        $this->personRepository = $personRepository;
        $this->addressService = $addressService;
    }

    /**
     * Получить всех ФЛ.
     * @return Collection
     */
    public function getAll()
    {
        return $this->personRepository->getAll();
    }

    /**
     * Получить ФЛ по ИД.
     * @param $id
     * @return Person Получить всех контрагентов
     */
    public function getById($id)
    {
        return $this->personRepository->getById($id);
    }

    /**
     * Создать ФЛ.
     * @param Request $data
     * @return Person
     */
    public function create(Request $data)
    {
        // Если был найден и выбран адрес
        if (!empty($data->address['fias_id'])) {
            $data->fias_address_id = ($this->addressService->findOrCreate($data->address))->id;
        }
        return $this->personRepository->create($data);
    }

    /**
     * Обновить ФЛ.
     * @param int $id
     * @param Request $data
     * @return Person
     */
    public function update(int $id, Request $data)
    {
        $person = $this->personRepository->getById($id);

        // Если адрес был изменён
        if (!empty($data->address['fias_id'])) {
            $data->fias_address_id = ($this->addressService->findOrCreate($data->address))->id;
        }

        return $this->personRepository->update($id, $data);
    }

    /**
     * Удалить контрагента.
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->personRepository->delete($id);
    }

    /**
     * Загрузить фотографию пользователя
     * @param $file
     * @return mixed
     */
    public function uploadPhoto($file)
    {
        $filename = $file->getClientOriginalName();
        $path = 'images/users';

        Image::make($file)->encode('jpg')->save(public_path("storage/$path/$filename"));

        $thumbnail = Image::make($file)->encode('jpg');
        $thumbnail->fit(256, 256, function ($constraint) {
            $constraint->aspectRatio();
        });
        $thumbnail->save(public_path("storage/thumbnail/$path/$filename"));

        return [
            'filename' => "$path/$filename",
        ];
    }

}
