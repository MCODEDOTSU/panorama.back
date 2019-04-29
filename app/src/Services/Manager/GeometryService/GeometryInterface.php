<?php

namespace App\src\Services\Manager\GeometryService;

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
     * Изменить свойства геометрии.
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, $data = []);

    /**
     * Удалили.
     * @param int $id
     * @return array
     */
    public function delete(int $id);

}
