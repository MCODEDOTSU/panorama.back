<?php

namespace App\src\Services\Geo;

use App\src\Repositories\Geo\GeometryRepository;
use App\src\Repositories\Info\AddressRepository;
use App\src\Repositories\Geo\LayerCompositionRepository;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Element;

/**
 * Class ElementService
 * @package App\src\Services\Geo
 */
class ElementService
{
    protected $elementRepository;
    protected $addressRepository;
    protected $layerRepositoryRepository;

    /**
     * ElementService constructor.
     * @param GeometryRepository $elementRepository
     * @param AddressRepository $addressRepository
     * @param LayerCompositionRepository $layerRepositoryRepository
     */
    public function __construct(GeometryRepository $elementRepository,
                                AddressRepository $addressRepository,
                                LayerCompositionRepository $layerRepositoryRepository)
    {
        $this->elementRepository = $elementRepository;
        $this->addressRepository = $addressRepository;
        $this->layerRepositoryRepository = $layerRepositoryRepository;
    }

    /**
     * Получить элементы слоя
     * @param $layerId
     * @return Collection
     */
    public function getElementsByLayer($layerId): Collection
    {
        $elements = $this->elementRepository->getElementsByLayer($layerId);

        foreach ($elements as &$element) {
            $element['geometries'] = [
                'points' => $this->getPoints($element),
                'linestrings' => $this->getLinestrings($element),
                'polygons' => $this->getPolygons($element),
            ];
        }

        return $elements;
    }

    /**
     * Получить элемент по ИД
     * @param $elementId
     * @return
     */
    public function getElementById($elementId)
    {
        $element = $this->elementRepository->getElementById($elementId);
        $element['geometries'] = [
            'points' => $this->getPoints($element),
            'linestrings' => $this->getLinestrings($element),
            'polygons' => $this->getPolygons($element),
        ];
        return $element;
    }

    /**
     * Создать новый элемент слоя.
     * @param $data
     * @return \App\src\Models\Element
     */
    public function create($data)
    {
        return $this->elementRepository->create($data);
    }

    /**
     * Сохранить изменения в элементе
     * @param $elementId
     * @param $data
     * @return \App\src\Models\Element|mixed
     */
    public function update($elementId, $data)
    {
        $element = $this->elementRepository->getById($elementId);
        $element = $this->elementRepository->update($element, $data);
        return $element;
    }

    /**
     * Удалить элемент.
     * @param $elementId
     * @return array
     */
    public function delete($elementId)
    {
        return $this->elementRepository->delete($elementId);
    }

    /**
     * Получить полную информацию по точкам
     * @param $element
     * @return array
     */
    private function getPoints($element)
    {
        $points = [];
        if ($element->points) {
            foreach ($element->points as $point) {
                if (!empty($point->address_id)) {
                    $point->address = $this->addressRepository->getById($point->address_id);
                }
                $point->style = $this->getStyle($point->layer_composition_id);
                $points[$point->id] = $point;
            }
        }
        return $points;
    }

    /**
     * Получить полную информацию по линиям
     * @param $element
     * @return array
     */
    private function getLinestrings($element)
    {
        $linestrings = [];
        if (!$element->linestrings) {
            return $linestrings;
        }
        foreach ($element->linestrings as $linestring) {
            if (!empty($linestring->address_id)) {
                $linestring->address = $this->addressRepository->getById($linestring->address_id);
            }
            $linestring->style = $this->getStyle($linestring->layer_composition_id);
            $linestrings[$linestring->id] = $linestring;
        }
        return $linestrings;
    }

    /**
     * Получить полную информацию по полигонам
     * @param $element
     * @return array
     */
    private function getPolygons($element)
    {
        $polygons = [];
        if (!$element->polygons) {
            return $polygons;
        }
        foreach ($element->polygons as $polygon) {
            if (!empty($polygon->address_id)) {
                $polygon->address = $this->addressRepository->getById($polygon->address_id);
            }
            $polygon->style = $this->getStyle($polygon->layer_composition_id);
            $polygons[$polygon->id] = $polygon;
        }
        return $polygons;
    }

    /**
     * Получить композицию элемента
     * @param $compositionId
     * @return mixed
     */
    private function getStyle($compositionId) {
        $composition = $this->layerRepositoryRepository->getById($compositionId);
        return \GuzzleHttp\json_decode($composition->style);
    }

    /**
     * @param $title
     * @return Collection
     * Поиск по названию
     */
    public function searchByTitle($title)
    {
        $elements = $this->elementRepository->searchByTitle($title);

        foreach ($elements as &$element) {
            $element['geometries'] = [
                'points' => $this->getPoints($element),
                'linestrings' => $this->getLinestrings($element),
                'polygons' => $this->getPolygons($element),
            ];
        }

        return $elements;
    }

    /**
     * @param $title
     * @return Collection
     * Поиск по адресу
     */
    public function searchByAddress($address)
    {

        $elements = $this->elementRepository->searchByAddress($address);

        $slicedElements = new Collection();

        foreach ($elements as &$element) {

            foreach($element->points as $point) {
                $pointAddress = $this->addressRepository->searchByAddress($point->address_id, $address);

                if($pointAddress->isEmpty()) {
                    continue;
                } else {
                    $slicedElements->push($element);
                }
            }
        }

        foreach ($slicedElements as &$element) {
            $element['geometries'] = [
                'points' => $this->getPoints($element),
                'linestrings' => $this->getLinestrings($element),
                'polygons' => $this->getPolygons($element),
            ];
        }

        return $slicedElements->keyBy('id');
    }
}
