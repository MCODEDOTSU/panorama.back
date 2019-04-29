<?php

namespace App\src\Services\Manager\GeometryService;
use App\src\Repositories\Manager\GeometryRepository\PointRepository;

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
     * Обновить свойства точки.
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
