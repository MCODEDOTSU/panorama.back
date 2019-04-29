<?php

namespace App\src\Repositories\Geo;
use App\src\Models\Polygon;

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
        return $this->polygon->create($data);
    }

    /**
     * Обновить геометрию полигона.
     * @param int $id
     * @param $geometry
     * @return Polygon
     */
    public function updateGeometry(int $id, string $geometry): Polygon
    {
        $record = $this->polygon::find($id);
        $record->geom = $geometry;
        $record->save();
        return $record;
    }

    /**
     * Обновить свойства полигона.
     * @param int $id
     * @param array $data
     * @return Polygon
     */
    public function updateProperties(int $id, $data = []): Polygon
    {
        $record = $this->polygon::find($id);
        $record->title = $data['title'];
        $record->description = $data['description'];
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
