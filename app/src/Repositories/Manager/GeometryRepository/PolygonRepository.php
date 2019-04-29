<?php

namespace App\src\Repositories\Manager\GeometryRepository;
use App\src\Models\Polygon;

/**
 * Class PolygonRepository
 * @package App\src\Repositories\Manager\GeometryRepository
 */
class PolygonRepository
{
    protected $polygon;

    /**
     * PolygonRepository constructor.
     * @param $polygon
     */
    public function __construct(Polygon $polygon)
    {
        $this->polygon = $polygon;
    }

    /**
     * Создать новый полигон.
     * @param $data
     * @return Polygon
     */
    public function create($data): Polygon
    {
        $record = $this->polygon->create($data);
        return $record;
    }

    /**
     * Обновить свойства полигона.
     * @param int $id
     * @param array $data
     * @return Polygon
     */
    public function update(int $id, $data = []): Polygon
    {
        $record = $this->polygon::find($id);
        $record->title = $data['title'];
        $record->description = $data['description'];
        $record->address_id = $data['address_id'];
        $record->save();
        return $record;
    }

    /**
     * Удалить элемент.
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $record = $this->polygon::find($id);
        $record->delete();
        return ['id' => $id];
    }

}
