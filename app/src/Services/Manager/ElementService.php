<?php

namespace App\src\Services\Manager;
use App\src\Models\Element;
use App\src\Services\AddressService;
use App\src\Repositories\Manager\ElementRepository;
use App\src\Services\Constructor\AdditionalInfoService;
use App\src\Services\Manager\ElementGraphService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Class ElementService
 * @package App\src\Services\Manager
 */
class ElementService
{
    protected $elementRepository;
    protected $elementGraphService;
    protected $additionalInfoService;
    private $addressService;

    /**
     * ElementService constructor.
     * @param ElementRepository $elementRepository
     * @param AdditionalInfoService $additionalInfoService
     */
    public function __construct(ElementRepository $elementRepository,
                                ElementGraphService $elementGraphService,
                                AdditionalInfoService $additionalInfoService,
                                AddressService $addressService)
    {
        $this->elementRepository = $elementRepository;
        $this->elementGraphService = $elementGraphService;
        $this->additionalInfoService = $additionalInfoService;
        $this->addressService = $addressService;
    }

    /**
     * Список элементов слоя.
     * @param $layerId
     * @return Collection
     */
    public function getAll($layerId)
    {
        return $this->elementRepository->getAll($layerId);
    }

    /**
     * Список элементов слоя (с пагинацией).
     * @param $layerId
     * @param $limit
     * @param $page
     * @return Collection
     */
    public function getAllLimit($layerId, $limit, $page)
    {
        return $this->elementRepository->getAllLimit($layerId, $limit, $limit * $page);
    }

    /**
     * Получить количество элементов слоя.
     * @param $layerId
     * @return int
     */
    public function getCount($layerId)
    {
        return $this->elementRepository->getCount($layerId);
    }

    /**
     * Получить элементы по поиску (с пагинацией).
     * @param $search
     * @param $limit
     * @param $page
     * @return Collection
     */
    public function getSearchLimit($search, $limit, $page)
    {
        return $this->elementRepository->getSearchLimit($search, $limit, $limit * $page);
    }

    /**
     * Получить количество элементов по поиску.
     * @param $search
     * @return int
     */
    public function getSearchCount($search)
    {
        return $this->elementRepository->getSearchCount($search);
    }

    /**
     * Получить элемент по ИД.
     * @param int $id
     * @return Element
     */
    public function getById(int $id)
    {
        $element = $this->elementRepository->getById($id);
        $element['previous'] = $this->elementGraphService->getPrevious($id);
        return $element;
    }

    /**
     * Создать элемент.
     * @param Request $data
     * @return Element
     */
    public function create(Request $data)
    {
        $element = $this->elementRepository->create($data);
        if(!empty($data->additionalData)) {
            $this->additionalInfoService->create($element->id, $data->additionalData);
        }
        $previous = $data->previous;
        if($previous['next_element_id'] == 0) {
            $previous['next_element_id'] = $element->id;
        }
        $this->elementGraphService->update($previous);
        return $element;
    }

    /**
     * Обновить элемент.
     * @param int $id - elementId
     * @param Request $data
     * @return Element
     */
    public function update(int $id, Request $data)
    {
        if(!empty($data->additionalData)) {
            $this->additionalInfoService->update($id, $data->additionalData, $data->layer_id);
        }
        $this->elementGraphService->update($data->previous);
        return $this->elementRepository->update($id, $data);
    }

    /**
     * Удалить элемент.
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function delete(int $id)
    {
        $element = $this->getById($id);
        $this->additionalInfoService->delete($id, $element->layer_id);
        $this->elementGraphService->deleteAll($id);
        return $this->elementRepository->delete($id);
    }

    /**
     * Удалить несколько элементов.
     * @param $elements
     * @param $layerId
     * @return array
     * @throws Exception
     */
    public function deleteSome($elements, $layerId)
    {
        $this->additionalInfoService->deleteSome($elements, $layerId);
        $this->elementGraphService->deleteSomeAll($elements);
        return $this->elementRepository->deleteSome($elements);
    }

    /**
     * Получить граф элемента
     * @param int $id
     * @return \App\src\Models\ElementGraph[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws Exception
     */
    public function getNext(int $id)
    {
        $next = $this->elementGraphService->getNext($id);
        foreach ($next as &$graph) {
            $graph['next_element']['next'] = $this->getNext($graph->next_element_id);
        }
        return $next;
    }

}
