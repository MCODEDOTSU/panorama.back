<?php

namespace App\src\Services\Manager;
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

    /**
     * ElementService constructor.
     * @param ElementRepository $elementRepository
     * @param AdditionalInfoService $additionalInfoService
     */
    public function __construct(ElementRepository $elementRepository, AdditionalInfoService $additionalInfoService)
    {
        $this->elementRepository = $elementRepository;
        $this->additionalInfoService = $additionalInfoService;
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
     * @param int $id
     * @param Request $data
     * @return \App\src\Models\Element
     */
    public function update(int $id, Request $data)
    {
        $this->additionalInfoService->update($id, $data->additionalData);
        return $this->elementRepository->update($id, $data);
    }

    /**
     * Создать элемент.
     * @param Request $data
     * @return void
     */
    public function create(Request $data)
    {
        $element = $this->elementRepository->create($data);
        $this->additionalInfoService->create($data->additionalData, $element->id);
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
