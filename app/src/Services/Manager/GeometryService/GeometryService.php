<?php

namespace App\src\Services\Manager\GeometryService;
use App\src\Repositories\Manager\GeometryRepository\GeometryRepository;
use App\src\Services\Info\AddressService;

/**
 * Class GeometryService
 * @package App\src\Services\Geo\GeometryService
 */
class GeometryService
{

    private $geometryResolver;
    private $geometryRepository;
    private $addressService;

    /**
     * GeometryService constructor.
     * @param GeometryRepository $geometryRepository
     * @param GeometryResolver $geometryResolver
     * @param AddressService $addressService
     */
    public function __construct(GeometryRepository $geometryRepository,
                                GeometryResolver $geometryResolver,
                                AddressService $addressService)
    {
        $this->geometryRepository = $geometryRepository;
        $this->geometryResolver = $geometryResolver;
        $this->addressService = $addressService;
    }

    /**
     * Получить геометрию всех элементов слоя
     * @param int $elementId
     * @return \Illuminate\Support\Collection
     */
    public function getAll(int $elementId)
    {
        return $this->geometryRepository->getByElementId($elementId);
    }

    /**
     * Создать новую геометрию.
     * @param $data
     * @param string $type
     * @return mixed
     */
    public function create($data, string $type)
    {
        $address = $this->addressService->create([
            'city' => $data->city,
            'street' => $data->street,
            'build' => $data->build,
        ]);
        $geometry = $this->geometryResolver->resolveGeometry($type)->create([
            'title' => $data->title,
            'description' => $data->description,
            'address_id' => $address->id,
            'element_id' => $data->element_id,
            'layer_composition_id' => $data->layer_composition_id,
        ]);
        $geometry->city = $data->city;
        $geometry->street = $data->street;
        $geometry->build = $data->build;
        return $geometry;
    }

    /**
     * Обновить свойства геометрии.
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, $data, string $type)
    {
        $this->addressService->update($data->address_id, [
            'city' => $data->city,
            'street' => $data->street,
            'build' => $data->build,
        ]);
        $geometry = $this->geometryResolver->resolveGeometry($type)->update($id, $data);
        $geometry->city = $data->city;
        $geometry->street = $data->street;
        $geometry->build = $data->build;
        return $geometry;
    }

    /**
     * Удалить геометрию.
     * @param int $id
     * @param string $type
     * @return mixed
     */
    public function delete(int $id, string $type)
    {
        return $this->geometryResolver->resolveGeometry($type)->delete($id);
    }

}
