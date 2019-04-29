<?php

namespace App\src\Services\Geo\GeometryService;

/**
 * Interface GeometryInterface
 * @package App\src\Services\Geo\GeometryService
 */
interface GeometryInterface
{

    /**
     * Создать новую геометрию.
     * @param array $data
     * @return mixed
     */
    public function create($data = []);

    /**
     * Изменить геометрию.
     * @param int $id
     * @param string $geometry
     * @return mixed
     */
    public function updateGeometry(int $id, string $geometry);

    /**
     * Изменить свойства геометрии.
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, $data = []);

}
