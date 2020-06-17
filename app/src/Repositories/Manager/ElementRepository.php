<?php

namespace App\src\Repositories\Manager;

use App\src\Models\Element;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class ElementRepository
 * @package App\src\Repositories\Manager
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
     * Список элементов слоя.
     * @param $layerId
     * @return Collection
     */
    public function getAll(int $layerId): Collection
    {
        return $this->element
            ->select(DB::raw('*, ST_AsText(geometry) as geometry'))
            ->where('layer_id', $layerId)
            ->with('next')
            ->orderBy('title', 'asc')
            ->get();
    }

    /**
     * Список элементов слоя.
     * @param int $layerId
     * @param int $limit
     * @param int $offset
     * @return Collection
     */
    public function getAllLimit(int $layerId, int $limit, int $offset): Collection
    {
        return $this->element
            ->select(DB::raw('*, ST_AsText(geometry) as geometry'))
            ->where('layer_id', $layerId)
            ->with('next')
            ->skip($offset)
            ->take($limit)
            ->orderBy('title', 'asc')
            ->get();
    }

    /**
     * Получить количество элементов слоя.
     * @param int $layerId
     * @return int
     */
    public function getCount(int $layerId): int
    {
        return $this->element
            ->where('layer_id', $layerId)
            ->count();
    }

    /**
     * Получить элемент по ИД
     * @param $id
     * @return Element
     */
    public function getById(int $id)
    {
        return $this->element
            ->select(DB::raw('*, ST_AsText(geometry) as geometry'))
            ->where('id', $id)
            ->first();
    }

    /**
     * Создать элемент.
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
        if(!empty($data->geometry)) $value['geometry'] = $data->geometry;

        $record = $this->element->create($value);
        return $this->getById($record->id);
    }

    /**
     * Обновить элемент.
     * @param int $id
     * @param $data
     * @return Element
     */
    public function update(int $id, $data)
    {
        $record = $this->getById($id);
        $record->title = $data->title;
        $record->description = $data->description;
        if(!empty($data->geometry)) $record->geometry = $data->geometry;
        if(!empty($data->address_id)) $record->address_id = $data->address_id;
        $record->save();
        return $record;
    }

    /**
     * Удалить элемент.
     * @param $id
     * @return array
     * @throws Exception
     */
    public function delete(int $id)
    {
        $record = $this->getById($id);
        $record->delete();
        return ['id' => $id];
    }

    /**
     * Удалить несколько элементов.
     * @param $elements
     * @return array
     */
    public function deleteSome($elements)
    {
        $this->element->whereIn('id', $elements)->delete();
        return ['ids' => $elements];
    }

    /**
     * @param string $title
     * @return Collection|null
     */
    public function getByTitle(string $title): ?Collection
    {
        return $this->element
            ->where('title', '=', $title)
            ->get();
    }
}
