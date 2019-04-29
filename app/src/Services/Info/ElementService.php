<?php

namespace App\src\Services\Info;


use App\src\Repositories\Info\AddressRepository;
use App\src\Repositories\Info\ElementRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ElementService
{
    protected $elementRepository;
    protected $addressRepository;

    /**
     * ElementService constructor.
     * @param ElementRepository $elementRepository
     * @param AddressRepository $addressRepository
     */
    public function __construct(ElementRepository $elementRepository, AddressRepository $addressRepository)
    {
        $this->elementRepository = $elementRepository;
        $this->addressRepository = $addressRepository;
    }

    /**
     * Получить элементы слоя
     * @param $layerId
     * @return Collection
     */
    public function getElementsByLayer($layerId): Collection
    {
        $elements = $this->elementRepository->getElementsByLayer($layerId);

        foreach ($elements as $element) {
            if($element->points) {
                foreach ($element->points as $point) {
                    if (!empty($point->address_id)) {
                        $point->address = $this->addressRepository->getById($point->address_id);
                    }
                }
            }

            if($element->polygons) {
                foreach ($element->polygons as $polygon) {
                    if (!empty($polygon->address_id)) {
                        $polygon->address = $this->addressRepository->getById($polygon->address_id);
                    }
                }
            }

            if($element->linestrings) {
                foreach ($element->linestrings as $linestring) {
                    if (!empty($linestring->address_id)) {
                        $linestring->address = $this->addressRepository->getById($linestring->address_id);
                    }
                }
            }
        }

        return $elements;
    }

    public function update(Request $data)
    {
        $element = $this->elementRepository->getById($data->id);

        $element = $this->elementRepository->update($element, $data);

        return $element;
    }

    public function create(Request $data)
    {
        $data->visibility = 'hidden'; // TODO: 
        $element = $this->elementRepository->create($data);

        return $element;
    }

    public function delete($id)
    {
        $result = $this->elementRepository->delete($id);

        return $result;
    }

}