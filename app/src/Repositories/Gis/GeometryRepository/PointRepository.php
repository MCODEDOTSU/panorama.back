<?php

namespace App\src\Repositories\Gis\GeometryRepository;
use App\src\Models\Point;

/**
 * Class PointRepository
 * @package App\src\Repositories\Gis\GeometryRepository
 */
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
     * Обновить свойства точки
     * @param int $id
     * @param array $data
     * @return Point
     */
    public function update(int $id, $data = []): Point
    {
        $record = $this->point::find($id);
        $record->title = $data['title'];
        $record->description = $data['description'];
        $record->geom = $data['geom'];
        $record->save();
        return $record;
    }

    /**
     * Удалить
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $record = $this->point::find($id);
        $record->delete();
        return ['id' => $id];
    }

}
