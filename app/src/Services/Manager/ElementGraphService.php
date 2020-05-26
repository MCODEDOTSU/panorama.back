<?php

namespace App\src\Services\Manager;
use App\src\Models\ElementGraph;
use App\src\Repositories\Manager\ElementGraphRepository;

/**
 * Class ElementGraphService
 * @package App\src\Services\Gis
 */
class ElementGraphService
{
    protected $elementGraphRepository;

    /**
     * ElementService constructor.
     * @param ElementGraphRepository $elementGraphRepository
     */
    public function __construct(ElementGraphRepository $elementGraphRepository)
    {
        $this->elementGraphRepository = $elementGraphRepository;
    }

    /**
     * Получить связь с предыдущим элементом
     * @param $element_id
     * @return ElementGraph
     */
    public function getPrevious($element_id)
    {
        return $this->elementGraphRepository->getPrevious($element_id);
    }

    /**
     * Получить связь со следующим элементом
     * @param $element_id
     * @return ElementGraph[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getNext($element_id)
    {
        return $this->elementGraphRepository->getNext($element_id);
    }

    /**
     * Обновить связь
     * @param $data
     * @return ElementGraph
     */
    public function update($data)
    {
        if ($data['id'] == 0 && $data['element_id'] == 0) {
            return null;
        }

        if($data['id'] != 0 && $data['element_id'] == 0) {
            return $this->elementGraphRepository->delete($data['id']);
        }

        if ($data['element_id'] == $data['next_element_id']) {
            return null;
        }

        if($data['id'] == 0) {
            return $this->elementGraphRepository->create($data);
        }

        return $this->elementGraphRepository->update($data['id'], $data);
    }

    /**
     * Удалить все связи для элемента
     * @param $element_id
     * @return void
     */
    public function deleteAll($element_id)
    {
        $this->elementGraphRepository->deleteAll($element_id);
    }

}
