<?php

namespace App\src\Services\Gis;
use App\src\Models\Element;
use App\src\Repositories\Gis\ElementRepository;
use Exception;

/**
 * Class ElementService
 * @package App\src\Services\Geo
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
     * Создать новый элемент слоя.
     * @param $data
     * @return Element
     */
    public function create($data)
    {
        return $this->elementRepository->create($data);
    }

    /**
     * Сохранить изменения в элементе
     * @param $id
     * @param $data
     * @return Element|mixed
     */
    public function update($id, $data)
    {
        return $this->elementRepository->update($id, $data);
    }

    /**
     * Сохранить изменения в геометрии элемента
     * @param $id
     * @param $data
     * @return Element|mixed
     */
    public function updateGeometry($id, $data)
    {
        return $this->elementRepository->updateGeometry($id, $data);
    }

    /**
     * Удалить элемент.
     * @param $id
     * @return array
     * @throws Exception
     */
    public function delete($id)
    {
        return $this->elementRepository->delete($id);
    }

    /**
     * Получить все связанные элементы.
     * @param $id
     * @return array
     * @throws Exception
     */
    public function links($id)
    {
        return $this->elementRepository->links($id);
    }

}
