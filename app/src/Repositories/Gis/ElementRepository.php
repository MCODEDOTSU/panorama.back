<?php

namespace App\src\Repositories\Gis;
use App\src\Models\Element;
use Illuminate\Support\Facades\DB;

use App\src\Models\ConstructorMetadata;

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

    /**
     * Получить все связанные элементы.
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function links(int $id)
    {
        // В таблице constructor_metadata ищем всем записи где type = link_field
        $metadata = ConstructorMetadata::select('table_identifier', 'tech_title')
            ->where('type', 'link_field')
            ->where('is_deleted', 'false')
            ->get();

        // Для каждой пары table_identifier - tech_title получаем element_id
        $result = [];
        foreach ($metadata as $meta) {

            $rows = DB::table($meta['table_identifier'])
                ->select('element_id', $meta['tech_title'] . ' as parent')
                ->where($meta['tech_title'], $id)
                ->get();

            // Получаем данные для каждого элемента: слой, геометрию, стиль, заголовок
            foreach ($rows as &$row) {
                $row->data = $this->element
                    ->join('geo_layers', 'geo_layers.id', '=', 'geo_elements.layer_id')
                    ->select(DB::raw('geo_layers.id as layer_id, geo_elements.title, ST_AsText(geometry) as geometry, style'))
                    ->find($row->element_id);
                $row->parent = $this->element
                    ->select(DB::raw('id, ST_AsText(geometry) as geometry'))
                    ->find($row->parent);
            }

            $result = array_merge($result, $rows->toArray());
        }

        // Если массив не пустой, повторяем рекурсивно для каждого элемента
        if (count($result) != 0) {
            foreach ($result as $row) {
                $child = $this->links($row->element_id);
                $result = array_merge($result, $child);
            }
        }

        return $result;
    }

    /**
     * Получить элемент по наименованию
     * @param $name
     * @return mixed
     */
    public function getByName($name)
    {
        return $this->element
            ->where('title', '=', $name)
            ->first();
    }

}
