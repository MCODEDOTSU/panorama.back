<?php

namespace App\src\Repositories\Geo;

use App\src\Models\Layer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class LayerRepository
 * @package App\src\Repositories\Geo
 */
class LayerRepository
{
    protected $layer;

    /**
     * LayerRepository constructor.
     * @param $layer
     */
    public function __construct(Layer $layer)
    {
        $this->layer = $layer;
    }

    /**
     * Получить все слои
     * @return Collection
     */
    public function getLayers(): Collection
    {
        return $this->layer
            ->with([
                'elements' => function($query) {
                    $query
                        ->select(DB::raw(
                            '*, ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) as points_count,
                            ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) as linestrings_count,
                            ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL ) as polygons_count,
                            (
                                ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL )
                            ) as geometries_count'));
                },
            ])
            ->with('composition')
            ->get()
            ->keyBy('id');
    }

    /**
     * Получить все лои для редактирования.
     * @param $contractorId
     * @return Collection
     */
    public function getManagerLayers($contractorId): Collection
    {
        return $this->layer
            ->with([
                'elements' => function($query) {
                    $query
                        ->select(DB::raw(
                            '*, ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) as points_count,
                            ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) as linestrings_count,
                            ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL ) as polygons_count,
                            (
                                ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL )
                            ) as geometries_count'));
                },
            ])
            ->with('composition')
            ->whereHas('module', function ($query) use ($contractorId) {
                $query->whereHas('contractors', function ($query) use ($contractorId) {
                    $query->where('contractor_id', '=', $contractorId);
                });
            })
            ->get()
            ->keyBy('id');
    }

    /**
     * Получить все слои модуля
     * @param $moduleId
     * @return Collection
     */
    public  function  getLayersByModule($moduleId): Collection
    {
        return $this->layer
            ->where('module_id', $moduleId)
            ->with('elements')
            ->get()
            ->keyBy('id');
    }

}
