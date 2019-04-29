<?php

namespace App\src\Repositories\Manager;
use App\src\Models\Element;
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
     * Получить элемент по ИД
     * @param $id
     * @return Element
     */
    public function getById(int $id): Element
    {
        return $this->element
            ->select(DB::raw(
                '*, ( ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL )
                            ) as geometries_count'))
            ->where('id', $id)
            ->first();
    }

    /**
     * Список элементов слоя.
     * @param $layerId
     * @return Collection
     */
    public function getAll(int $layerId): Collection
    {
        return $this->element
            ->select(DB::raw(
                '*, ( ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL )
                            ) as geometries_count'))
            ->where('layer_id', $layerId)
            ->orderBy('title', 'asc')
            ->get();
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
        $record->save();
        return $record;
    }

    /**
     * Создать элемент.
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
     * Удалить композицию.
     * @param $id
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
