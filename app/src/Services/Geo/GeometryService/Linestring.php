<?php

namespace App\src\Services\Geo\GeometryService;

use App\src\Repositories\Geo\LinestringRepository;

/**
 * Class Linestring
 * @package App\src\Services\Geo\GeometryService
 */
class Linestring implements GeometryInterface
{
    public $type = 'linestring';
    private $geometryRepository;

    /**
     * Linestring constructor.
     * @param LinestringRepository $geometryRepository
     */
    public function __construct(LinestringRepository $geometryRepository)
    {
        $this->geometryRepository = $geometryRepository;
    }

    /**
     * Создать новую линию.
     * @param array $data
     * @return \App\src\Models\LineString|mixed
     */
    public function create($data = [])
    {
        return $this->geometryRepository->create($data);
    }

    /**
     * Изменить геометрию линии.
     * @param int $id
     * @param string $geometry
     * @return \App\src\Models\Point|mixed
     */
    public function updateGeometry(int $id, string $geometry)
    {
        return $this->geometryRepository->updateGeometry($id, $geometry);
    }

    /**
     * Обновить свойства линии.
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
