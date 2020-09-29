<?php

namespace App\src\Services;

use App\src\Models\Contractor;
use App\src\Repositories\ContractorRepository;
use App\src\Services\FiasAddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Image;

class ContractorService
{
    protected $contractorRepository;
    protected $addressService;

    /**
     * ContractorService constructor.
     * @param ContractorRepository $contractorRepository
     * @param FiasAddressService $addressService
     */
    public function __construct(ContractorRepository $contractorRepository,
                                FiasAddressService $addressService)
    {
        $this->contractorRepository = $contractorRepository;
        $this->addressService = $addressService;
    }

    /**
     * @return Collection
     * Получить всех контрагентов
     */
    public function getAll()
    {
        return $this->contractorRepository->getAll();
    }

    /**
     * Получить контрагента по ИД.
     * @param $id
     * @return Contractor Получить всех контрагентов
     */
    public function getById($id)
    {
        return $this->contractorRepository->getById($id);
    }

    /**
     * @param Request $data
     * @return Contractor
     * Создать контрагента
     */
    public function create(Request $data)
    {
        $contractorData = [
            'name' => $data->name,
            'full_name' => $data->full_name,
            'inn' => $data->inn,
            'kpp' => $data->kpp,
            'logo' => $data->logo,
        ];

        // Если был найден и выбран адрес
        if (!empty($data->address['fias_id'])) {
            $contractorData['fias_address_id'] = ($this->addressService->findOrCreate($data->address))->id;
        }

        $contractor = $this->contractorRepository->create($contractorData);
        return $this->contractorRepository->getById($contractor->id);
    }

    /**
     * Обновить котрагента.
     * @param Request $data
     * @return Contractor
     * @throws \Exception
     */
    public function update(Request $data)
    {
        $contractor = $this->contractorRepository->getById($data->id);

        // Если адрес был изменён
        if (!empty($data->address['fias_id']) && (empty($contractor->address) || $data->address['fias_id'] != $contractor->address['fias_id'])) {
            $data->fias_address_id = ($this->addressService->findOrCreate($data->address))->id;
        }

        if ($data->parent_id == $contractor->id) {
            throw new \Exception("ID контрагента и ID присваемого родительского контрагента не могут совпадать");
        }

        $this->contractorRepository->update($contractor, $data);
        return $this->contractorRepository->getById($data->id);
    }

    /**
     * Удалить контрагента.
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->contractorRepository->delete($id);
    }

    /**
     * Привязать модуль к контрагенту
     * @param $contractorId
     * @param $moduleId
     * @return mixed
     */
    public function attachModule($contractorId, $moduleId)
    {
        return $this->contractorRepository->attachModule($contractorId, $moduleId);
    }

    /**
     * Отвязать модуль от контрагента
     * @param $contractorId
     * @param $moduleId
     * @return mixed
     */
    public function detachModule($contractorId, $moduleId)
    {
        return $this->contractorRepository->detachModule($contractorId, $moduleId);
    }

    /**
     * Загрузить Логотип контрагента
     * @param $file
     * @return mixed
     */
    public function uploadLogo($file)
    {
        $path = $file->hashName('images/contractors');
        list($width, $height) = getimagesize($file);

        $image = Image::make($file);
        if($height > 152 || $width >= 760) {
            $image->resize(760, 152, function ($constraint) {
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
