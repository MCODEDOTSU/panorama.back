<?php

namespace App\src\Services\Geo\GeometryService;

/**
 * Class GeometryService
 * @package App\src\Services\Geo\GeometryService
 */
class GeometryService
{

    private $geometryResolver;

    /**
     * GeometryService constructor.
     * @param GeometryResolver $geometryResolver
     */
    public function __construct(GeometryResolver $geometryResolver)
    {
        $this->geometryResolver = $geometryResolver;
    }

    /**
     * Изменить геометрию.
     * @param int $id
     * @param string $geometry
     * @param string $type
     * @return mixed
     */
    public function updateGeometry(int $id, string $geometry, string $type)
    {
        return $this->geometryResolver->resolveGeometry($type)->updateGeometry($id, $geometry);
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

    public function delete(int $id, string $type)
    {
        return $this->geometryResolver->resolveGeometry($type)->delete($id);
    }

}
