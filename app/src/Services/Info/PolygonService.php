<?php

namespace App\src\Services\Info;


use App\src\Repositories\Geo\LayerCompositionRepository;
use App\src\Repositories\Geo\PolygonRepository;
use Illuminate\Http\Request;

class PolygonService
{
    protected $pointRepository;
    protected $elementService;
    protected $addressService;
    protected $layerCompositionRepository;

    /**
     * PointService constructor.
     * @param PolygonRepository $pointRepository
     * @param ElementService $elementService
     * @param AddressService $addressService
     * @param LayerCompositionRepository $layerCompositionRepository
     */
    public function __construct(PolygonRepository $pointRepository,
                                ElementService $elementService,
                                AddressService $addressService,
                                LayerCompositionRepository $layerCompositionRepository)
    {
        $this->pointRepository = $pointRepository;
        $this->elementService = $elementService;
        $this->addressService = $addressService;
        $this->layerCompositionRepository = $layerCompositionRepository;
    }

    public function update(Request $data)
    {
        $point = $this->pointRepository->getById($data->id);

        $point = $this->pointRepository->update($point, $data);

        $address = $this->addressService->update($data->address['id'], $data->address);

        $point->address = $address;

        return $point;
    }

    /**
     * @param $layerId
     * @param Request $data
     * @return mixed
     * Создать точку
     */
    public function create($layerId, Request $data)
    {
        // По умолчанию, при создании элемента без геометрии из "инфо", создает скрытый элемент
        $data->visibility = 'hidden';
        $element = $this->elementService->create($data);

        $address = $this->addressService->create($data);

        // Выбрать композицию для точки
        $layerComposition = $this->layerCompositionRepository
            ->getByLayerAndGeom('polygon', $data->layer_id);

        $point = $this->pointRepository->create([
            'title' => $data->title,
            'description' => $data->description,
            'element_id' => $element->id,
            'address_id' => $address->id,
            'layer_composition_id' => $layerComposition->id,
        ]);

        $point->address = $address;

        return $point;
    }

    public function delete($id)
    {
        $result = $this->pointRepository->delete($id);

        return $result;
    }

    public function singleCreate(Request $data)
    {
        $point = $this->pointRepository->create([
            'title' => $data->title,
            'description' => $data->description,
            'element_id' => $data->element_id,
            'layer_composition_id' => $data->layer_composition_id,
        ]);
    }

}
