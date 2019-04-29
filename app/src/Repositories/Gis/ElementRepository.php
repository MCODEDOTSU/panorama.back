<?php

namespace App\src\Repositories\Gis;
use App\src\Models\Element;

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
        return $this->element->find($id);
    }

    /**
     * Создать новый элемент слоя.
     * @param $data
     * @return Element
     */
    public function create($data): Element
    {
        $record = $this->element->create([
            'layer_id' => $data->layer_id,
            'title' => $data->title,
            'description' => $data->description,
        ]);
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
