<?php

namespace App\src\Services\Manager;
use App\src\Services\Info\AddressService;
use App\src\Repositories\Manager\ElementRepository;
use App\src\Services\Constructor\AdditionalInfoService;
use Illuminate\Http\Request;

/**
 * Class ElementService
 * @package App\src\Services\Manager
 */
class ElementService
{
    protected $elementRepository;
    protected $additionalInfoService;
    private $addressService;

    /**
     * ElementService constructor.
     * @param ElementRepository $elementRepository
     * @param AdditionalInfoService $additionalInfoService
     */
    public function __construct(ElementRepository $elementRepository,
                                AdditionalInfoService $additionalInfoService,
                                AddressService $addressService)
    {
        $this->elementRepository = $elementRepository;
        $this->additionalInfoService = $additionalInfoService;
        $this->addressService = $addressService;
    }

    /**
     * Список элементов слоя.
     * @param $layerId
     * @return \Illuminate\Support\Collection
     */
    public function getAll($layerId)
    {
        return $this->elementRepository->getAll($layerId);
    }

    /**
     * Получить элемент по ИД.
     * @param int $id
     * @return \App\src\Models\Element
     */
    public function getById(int $id)
    {
        return $this->elementRepository->getById($id);
    }

    /**
     * Обновить элемент.
     * @param int $id - elementId
     * @param Request $data
     * @return \App\src\Models\Element
     */
    public function update(int $id, Request $data)
    {
//        $this->addressService->update($data->address_id, [
//            'city' => $data->city,
//            'street' => $data->street,
//            'build' => $data->build,
//        ]);
        if(!empty($data->additionalData)) {
            $this->additionalInfoService->update($id, $data->additionalData, $data->layer_id);
        }
        return $this->elementRepository->update($id, $data);
    }

    /**
     * Создать элемент.
     * @param Request $data
     * @return \App\src\Models\Element
     */
    public function create(Request $data)
    {
//        $address = $this->addressService->create([
//            'city' => $data->city,
//            'street' => $data->street,
//            'build' => $data->build,
//        ]);
//        $data->address_id = $address->id;
        $element = $this->elementRepository->create($data);
        if(!empty($data->additionalData)) {
            $this->additionalInfoService->create($element->id, $data->additionalData);
        }
        return $element;
    }

    /**
     * Удалить элемент.
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function delete(int $id)
    {
        return $this->elementRepository->delete($id);
    }

}
