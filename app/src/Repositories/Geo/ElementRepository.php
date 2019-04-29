<?php

namespace App\src\Repositories\Geo;

use App\src\Models\Element;
use Illuminate\Support\Collection;
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
     * Получить все элементы слоя со всей геометрией
     * @param $layerId
     * @return Collection
     */
    public function getElementsByLayer($layerId): Collection
    {
        return $this->element
            ->select(DB::raw(
                '*, ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) as points_count,
                ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) as linestrings_count,
                ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL ) as polygons_count,
                (
                    ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) + 
                    ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) + 
                    ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL )
                ) as geometries_count'))
            ->where('layer_id', $layerId)
            ->with([
                'points' => function($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, layer_composition_id'));
                },
                'linestrings' => function($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, length, layer_composition_id'));
                },
                'polygons' => function($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, area, perimeter, layer_composition_id'));
                },
            ])
            ->get()
            ->keyBy('id');
    }

    /**
     * Получить элемент по ИД со всей геометрией
     * @param $elementId
     * @return
     */
    public function getElementById($elementId)
    {
        return $this->element
            ->select(DB::raw(
                '*, ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) as points_count,
                ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) as linestrings_count,
                ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL ) as polygons_count,
                (
                    ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) + 
                    ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) + 
                    ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL )
                ) as geometries_count'))
            ->where('id', $elementId)
            ->with([
                'points' => function($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, layer_composition_id'));
                },
                'linestrings' => function($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, length, layer_composition_id'));
                },
                'polygons' => function($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, area, perimeter, layer_composition_id'));
                },
            ])
            ->first();
    }

    /**
     * Получить элемент по ИД
     * @param $elementId
     * @return mixed
     */
    public function getById($elementId)
    {
        return $this->element->find($elementId);
    }

    /**
     * Создать новый элемент слоя.
     * @param $data
     * @return Element
     */
    public function create($data): Element
    {
        return $this->element->create($data);
    }

    /**
     * Сохранить изменения в элементе
     * @param Element $element
     * @param $data
     * @return Element
     */
    public function update(Element $element, $data): Element
    {
        $element->title = $data['title'];
        $element->description = $data['description'];
        $element->save();
        return $element;
    }

    /**
     * Удалить элемент.
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $element = $this->getById($id);
        $element->delete();
        return ['id' => $id];
    }

    /**
     * @param string $title
     * @return Collection
     * Найти элементы по названию
     */
    public function searchByTitle(string $title): Collection
    {
        return $this->element
            ->where(function ($query) use ($title) {
                $query->where('title', 'like', '%' . $title . '%');
            })
            ->with([
                'points' => function ($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, layer_composition_id'));
                },
                'linestrings' => function ($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, length, layer_composition_id'));
                },
                'polygons' => function ($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, area, perimeter, layer_composition_id'));
                },
            ])
            ->get()
            ->keyBy('id');
    }

    public function searchByAddress($address)
    {
        return $this->element
            ->with([
                'points' => function ($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, layer_composition_id'));
                },
                'linestrings' => function ($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, length, layer_composition_id'));
                },
                'polygons' => function ($query) {
                    $query
                        ->select(DB::raw('id, element_id, title, description, ST_AsText(geom) as geom, address_id, area, perimeter, layer_composition_id'));
                },
            ])
            ->get()
            ->keyBy('id');
    }


}
