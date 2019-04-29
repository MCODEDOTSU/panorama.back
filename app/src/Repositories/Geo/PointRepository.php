<?php

namespace App\src\Repositories\Geo;


use App\src\Models\Point;

class PointRepository
{
    protected $point;

    /**
     * PointRepository constructor.
     * @param $point
     */
    public function __construct(Point $point)
    {
        $this->point = $point;
    }

    /**
     * Создать новую точку.
     * @param $data
     * @return Point
     */
    public function create($data): Point
    {
        return $this->point->create($data);
    }

    /**
     * Обновить геометрию точки.
     * @param int $id
     * @param $geometry
     * @return Point
     */
    public function updateGeometry(int $id, string $geometry): Point
    {
        $record = $this->point::find($id);
        $record->geom = $geometry;
        $record->save();
        return $record;
    }

    /**
     * Обновить свойства точки
     * @param int $id
     * @param array $data
     * @return Point
     */
    public function updateProperties(int $id, $data = []): Point
    {
        $record = $this->point::find($id);
        $record->title = $data['title'];
        $record->description = $data['description'];
        $record->save();
        return $record;
    }

    public function getById($id): Point
    {
        return $this->point->find($id);
    }

    public function update(Point $point, $data)
    {
        $point->title = $data->title;
        $point->description = $data->description;

        $point->save();

        return $point;
    }

    public function delete($id)
    {
        $point = $this->getById($id);
        $point->delete();
        return ['id' => $id];
    }

}
