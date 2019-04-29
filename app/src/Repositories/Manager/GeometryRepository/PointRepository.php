<?php

namespace App\src\Repositories\Manager\GeometryRepository;
use App\src\Models\Point;

/**
 * Class PointRepository
 * @package App\src\Repositories\Manager\GeometryRepository
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
    public function create($data)
    {
        $record = $this->point->create($data);
        return $record;
    }

    /**
     * Обновить свойства точки
     * @param int $id
     * @param array $data
     * @return Point
     */
    public function update(int $id, $data = [])
    {
        $record = $this->point::find($id);
        $record->title = $data['title'];
        $record->description = $data['description'];
        $record->address_id = $data['address_id'];
        $record->save();
        return $record;
    }

    /**
     * Удалить
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function delete($id)
    {
        $record = $this->point::find($id);
        $record->delete();
        return ['id' => $id];
    }

}
