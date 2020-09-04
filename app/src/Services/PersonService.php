<?php

namespace App\src\Services;

use App\src\Models\Person;
use App\src\Repositories\PersonRepository;
use App\src\Services\AddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
     * @param AddressService $addressService
     */
    public function __construct(PersonRepository $personRepository,
                                AddressService $addressService)
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
        if (!empty($data->address)) {
            $address = $this->addressService->create($data->address);
            $data->address_id = $address->id;
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
        if (!empty($data->address)) {
            if (empty($data->address_id) || $data->address_id == 0) {
                $address = $this->addressService->create($data->address);
                $data->address_id = $address->id;
            } else {
                $this->addressService->update($data->address_id, $data->address);
            }
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
