<?php

namespace App\src\Repositories\Gis;
use App\src\Models\Element;
use Illuminate\Support\Facades\DB;

/**
 * Class ElementRepository
 * @package App\src\Repositories\Geo
 */
class ElementRepository
{
    protected $element;

    /**
     * ElementRepository constructor.
     * @param $element
     */
    public function __construct(Element $element)
    {
        $this->element = $element;
    }

    /**
     * Получить Элемент по ИД
     * @param $id
     * @return Element
     */
    public function getById($id): Element
    {
        return $this->element
            ->select(DB::raw('*, ST_AsText(geometry) as geometry'))
            ->find($id);
    }

    /**
     * Создать новый элемент слоя.
     * @param $data
     * @return Element
     */
    public function create($data): Element
    {
        $value = [
            'layer_id' => $data->layer_id,
            'title' => $data->title,
            'description' => $data->description,
        ];
        if(!empty($data->address_id)) $value['address_id'] = $data->address_id;
        if(!empty($data->element_next_id)) $value['element_next_id'] = $data->element_next_id;
        $record = $this->element->create($value);
        return $this->getById($record->id);
    }

    /**
     * Обновить элемент.
     * @param int $id
     * @param $data
     * @return Element
     */
    public function update(int $id, $data): Element
    {
        $record = $this->getById($id);
        $record->title = $data->title;
        $record->description = $data->description;
        if(!empty($data->address_id)) $record->address_id = $data->address_id;
        if(!empty($data->element_next_id)) $record->element_next_id = $data->element_next_id;
        $record->save();
        return $record;
    }

    /**
     * Обновить геометрию элемента.
     * @param int $id
     * @param $data
     * @return Element
     */
    public function updateGeometry(int $id, $data): Element
    {
        $record = $this->getById($id);
        if(!empty($data->geometry)) $record->geometry = $data->geometry;
        $record->save();
        return $record;
    }

    /**
     * Удалить элемент.
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $record = $this->getById($id);
        $record->delete();
        return ['id' => $id];
    }

}
