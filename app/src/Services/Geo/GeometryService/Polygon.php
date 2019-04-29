<?php

namespace App\src\Services\Geo\GeometryService;

use App\src\Repositories\Geo\PolygonRepository;

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
     * Изменить геометрию полигона.
     * @param int $id
     * @param string $geometry
     * @return \App\src\Models\Point|mixed
     */
    public function updateGeometry(int $id, string $geometry)
    {
        return $this->geometryRepository->updateGeometry($id, $geometry);
    }

    /**
     * Обновить свойства полигона.
     * @param int $id
     * @param array $data
     * @return mixed|void
     */
    public function update(int $id, $data = [])
    {
        return $this->geometryRepository->updateProperties($id, $data);
    }

    public function delete(int $id)
    {
        return $this->geometryRepository->delete($id);
    }
}
