<?php

namespace App\src\Services\Gis\GeometryService;
use App\src\Repositories\Gis\GeometryRepository\LinestringRepository;

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
     * Обновить свойства линии.
     * @param int $id
     * @param array $data
     * @return \App\src\Models\Point|mixed
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
