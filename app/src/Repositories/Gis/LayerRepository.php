<?php

namespace App\src\Repositories\Gis;
use App\src\Models\Layer;
use function foo\func;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class LayerRepository
 * @package App\src\Repositories\Gis
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
     * Список Всех слоёв
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->layer
            ->with([
                'elements' => function($query) {
                    $query
                        ->select(DB::raw(
                            '*, ( ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL )
                            ) as geometries_count'))
                        ->with([
                            'points' => function($pointsQuery) {
                                $pointsQuery->select(DB::raw('*, ST_AsText(geo_points.geom) as geom'))
                                    ->join('address', 'address.id', '=', 'geo_points.address_id');
                            },
                            'linestrings' => function($linestringsQuery) {
                                $linestringsQuery->select(DB::raw('*, ST_AsText(geo_linestrings.geom) as geom'))
                                    ->join('address', 'address.id', '=', 'geo_linestrings.address_id');
                            },
                            'polygons' => function($polygonsQuery) {
                                $polygonsQuery->select(DB::raw('*, ST_AsText(geo_polygons.geom) as geom'))
                                    ->join('address', 'address.id', '=', 'geo_polygons.address_id');
                            },
                        ])
                        ->orderBy('title', 'asc');
                },
            ])
            ->with('composition')
            ->get();
    }

    /**
     * Список слоёв для контрагента.
     * @return Collection
     */
    public function getAllToContractor($contractorId): Collection
    {
        return $this->layer
            ->with([
                'elements' => function($query) {
                    $query
                        ->select(DB::raw(
                            '*, ( ( SELECT COUNT(*) FROM geo_points WHERE geo_points.element_id = geo_elements.id AND geo_points.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_linestrings WHERE geo_linestrings.element_id = geo_elements.id AND geo_linestrings.geom IS NOT NULL ) + 
                                ( SELECT COUNT(*) FROM geo_polygons WHERE geo_polygons.element_id = geo_elements.id AND geo_polygons.geom IS NOT NULL )
                            ) as geometries_count'))
                        ->orderBy('title', 'asc');
                },
            ])
            ->with('composition')
            ->whereHas('module', function ($query) use ($contractorId) {
                $query->whereHas('contractors', function ($query) use ($contractorId) {
                    $query->where('contractor_id', '=', $contractorId);
                });
            })
            ->get();
    }

}
