<?php

namespace App\src\Services\Gis\GeometryService;
use App\src\Repositories\Gis\GeometryRepository\PolygonRepository;

/**
 * Class Linestring
 * @package App\src\Services\Geo\GeometryService
 */
class Polygon implements GeometryInterface
{
    public $type = 'polygon';
    private $geometryRepository;

    /**
     * Polygon constructor.
     * @param PolygonRepository $geometryRepository
     */
    public function __construct(PolygonRepository $geometryRepository)
    {
        $this->geometryRepository = $geometryRepository;
    }

    /**
     * Создать новый полигон.
     * @param array $data
     * @return \App\src\Models\LineString|mixed
     */
    public function create($data = [])
    {
        return $this->geometryRepository->create($data);
    }

    /**
     * Обновить свойства полигона.
     * @param int $id
     * @param array $data
     * @return \App\src\Models\LineString|mixed
     */
    public function update(int $id, $data = [])
    {
        return $this->geometryRepository->update($id, $data);
    }

    /**
     * Удалить
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->geometryRepository->delete($id);
    }
}
