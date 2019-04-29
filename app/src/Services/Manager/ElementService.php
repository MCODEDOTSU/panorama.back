<?php

namespace App\src\Services\Manager;
use App\src\Repositories\Manager\ElementRepository;
use Illuminate\Http\Request;

/**
 * Class ElementService
 * @package App\src\Services\Manager
 */
class ElementService
{
    protected $elementRepository;

    /**
     * ElementService constructor.
     * @param ElementRepository $elementRepository
     */
    public function __construct(ElementRepository $elementRepository)
    {
        $this->elementRepository = $elementRepository;
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
        return $this->elementRepository->update($id, $data);
    }

    /**
     * Создать элемент.
     * @param Request $data
     * @return \App\src\Models\Element
     */
    public function create(Request $data)
    {
        return $this->elementRepository->create($data);
    }

    /**
     * Удалить элемент.
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->elementRepository->delete($id);
    }

}
