<?php

namespace App\src\Repositories\Manager\GeometryRepository;
use App\src\Models\Point;
use App\src\Models\LineString;
use App\src\Models\Polygon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class GeometryRepository
 * @package App\src\Repositories\Manager\GeometryRepository
 */
class GeometryRepository
{
    protected $point;
    protected $linestring;
    protected $polygon;

    /**
     * ElementRepository constructor.
     * @param Point $point
     * @param LineString $linestring
     * @param Polygon $polygon
     */
    public function __construct(Point $point, LineString $linestring, Polygon $polygon)
    {
        $this->point = $point;
        $this->linestring = $linestring;
        $this->polygon = $polygon;
    }

    /**
     * Получить геометрию по ИД элемента
     * @param $elementId
     * @return Collection
     */
    public function getByElementId(int $elementId)
    {
        $pointQuery = $this->point
            ->select(DB::raw(
                'geo_points.created_at, geo_points.id, geo_points.title, geo_points.layer_composition_id, 
                geo_points.description, NULL as length, NULL as area, NULL as perimeter,
                address.city, address.street, address.build, address.id as address_id, \'point\' as type'
            ))
            ->leftJoin('address', 'address.id', '=', 'geo_points.address_id')
            ->where('element_id', $elementId);

        $linestringQuery = $this->linestring
            ->select(DB::raw(
                'geo_linestrings.created_at, geo_linestrings.id, geo_linestrings.title, geo_linestrings.layer_composition_id,
                geo_linestrings.description, geo_linestrings.length, NULL as area, NULL as perimeter,
                address.city, address.street, address.build, address.id as address_id, \'linestring\' as type'))
            ->leftJoin('address', 'address.id', '=', 'geo_linestrings.address_id')
            ->where('element_id', $elementId);

        return $this->polygon
            ->select(DB::raw(
                'geo_polygons.created_at, geo_polygons.id, geo_polygons.title, geo_polygons.layer_composition_id,
                geo_polygons.description, NULL as length, geo_polygons.area, geo_polygons.perimeter,
                address.city, address.street, address.build, address.id as address_id, \'polygon\' as type'))
            ->leftJoin('address', 'address.id', '=', 'geo_polygons.address_id')
            ->where('element_id', $elementId)
            ->union($pointQuery)
            ->union($linestringQuery)
            ->orderBy('created_at', 'asc')
            ->get();
    }

}
