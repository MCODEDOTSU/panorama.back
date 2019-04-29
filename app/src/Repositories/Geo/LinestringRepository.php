<?php

namespace App\src\Repositories\Geo;
use App\src\Models\LineString;

class LinestringRepository
{
    protected $linestring;

    /**
     * LinestringRepository constructor.
     * @param $linestring
     */
    public function __construct(LineString $linestring)
    {
        $this->linestring = $linestring;
    }

    /**
     * Создать новую лини.
     * @param $data
     * @return LineString
     */
    public function create($data): LineString
    {
        return $this->linestring->create($data);
    }

    /**
     * Обновить геометрию линии.
     * @param int $id
     * @param $geometry
     * @return LineString
     */
    public function updateGeometry(int $id, string $geometry): LineString
    {
        $record = $this->linestring::find($id);
        $record->geom = $geometry;
        $record->save();
        return $record;
    }

    /**
     * Обновить свойства линии.
     * @param int $id
     * @param array $data
     * @return LineString
     */
    public function updateProperties(int $id, $data = []): LineString
    {
        $record = $this->linestring::find($id);
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
        $record = $this->linestring::find($id);
        $record->delete();
        return ['id' => $id];
    }

}
