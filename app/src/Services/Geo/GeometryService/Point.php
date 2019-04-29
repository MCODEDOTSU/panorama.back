<?php

namespace App\src\Services\Geo\GeometryService;

use App\src\Repositories\Geo\PointRepository;

/**
 * Class Point
 * @package App\src\Services\Common\Geo\ElementService
 */
class Point implements GeometryInterface
{
    public $type = 'point';
    private $geometryRepository;

    /**
     * Point constructor.
     * @param PointRepository $geometryRepository
     */
    public function __construct(PointRepository $geometryRepository)
    {
        $this->geometryRepository = $geometryRepository;
    }

    /**
     * Создать новую точку.
     * @param array $data
     * @return \App\src\Models\LineString|mixed
     */
    public function create($data = [])
    {
        return $this->geometryRepository->create($data);
    }

    /**
     * Изменить геометрию точки.
     * @param int $id
     * @param string $geometry
     * @return \App\src\Models\Point|mixed
     */
    public function updateGeometry(int $id, string $geometry)
    {
        return $this->geometryRepository->updateGeometry($id, $geometry);
    }

    /**
     * Обновить свойства точки.
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
