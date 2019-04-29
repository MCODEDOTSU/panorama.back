<?php

namespace App\src\Services\Gis\GeometryService;
use App\src\Repositories\Gis\GeometryRepository\GeometryRepository;

/**
 * Class GeometryService
 * @package App\src\Services\Geo\GeometryService
 */
class GeometryService
{

    private $geometryResolver;
    private $geometryRepository;

    /**
     * GeometryService constructor.
     * @param GeometryRepository $geometryRepository
     * @param GeometryResolver $geometryResolver
     */
    public function __construct(GeometryRepository $geometryRepository,
                                GeometryResolver $geometryResolver)
    {
        $this->geometryRepository = $geometryRepository;
        $this->geometryResolver = $geometryResolver;
    }

    /**
     * Получить геометрию по ИД элемента
     * @param $geometryId
     * @return mixed
     */
    public function getByElementId(int $geometryId)
    {
        return $this->geometryRepository->getByElementId($geometryId);
    }

    /**
     * Получить геометрию всех элементов слоя
     * @param int $layerId
     * @return \Illuminate\Support\Collection
     */
    public function getByLayerId(int $layerId)
    {
        return $this->geometryRepository->getByLayerId($layerId);
    }

    /**
     * Создать новую геометрию.
     * @param $data
     * @param string $type
     * @return mixed
     */
    public function create($data, string $type)
    {
        return $this->geometryResolver->resolveGeometry($type)->create($data);
    }

    /**
     * Обновить свойства геометрии.
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, $data, string $type)
    {
        return $this->geometryResolver->resolveGeometry($type)->update($id, $data);
    }

    public function delete(int $id, string $type)
    {
        return $this->geometryResolver->resolveGeometry($type)->delete($id);
    }

}
