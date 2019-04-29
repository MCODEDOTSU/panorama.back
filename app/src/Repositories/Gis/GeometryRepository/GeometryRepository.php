<?php

namespace App\src\Repositories\Gis\GeometryRepository;
use App\src\Models\Point;
use App\src\Models\LineString;
use App\src\Models\Polygon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class ElementRepository
 * @package App\src\Repositories\Geo
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
                'geo_points.created_at, geo_points.element_id, geo_points.id, geo_points.title, geo_points.layer_composition_id, 
                NULL as length, NULL as area, NULL as perimeter,
                address.city, address.street, address.build,
                ST_AsText(geo_points.geom) as geom, \'point\' as type'
            ))
            ->leftJoin('address', 'address.id', '=', 'geo_points.address_id')
            ->where('element_id', $elementId);

        $linestringQuery = $this->linestring
            ->select(DB::raw(
                'geo_linestrings.created_at, geo_linestrings.element_id, geo_linestrings.id, geo_linestrings.title, geo_linestrings.layer_composition_id,
                geo_linestrings.length, NULL as area, NULL as perimeter,
                address.city, address.street, address.build,
                ST_AsText(geo_linestrings.geom) as geom, \'linestring\' as type'))
            ->leftJoin('address', 'address.id', '=', 'geo_linestrings.address_id')
            ->where('element_id', $elementId);

        return $this->polygon
            ->select(DB::raw(
                'geo_polygons.created_at, geo_polygons.element_id, geo_polygons.id, geo_polygons.title, geo_polygons.layer_composition_id,
                NULL as length, geo_polygons.area, geo_polygons.perimeter,
                address.city, address.street, address.build,
                ST_AsText(geo_polygons.geom) as geom, \'polygon\' as type'))
            ->leftJoin('address', 'address.id', '=', 'geo_polygons.address_id')
            ->where('element_id', $elementId)
            ->union($pointQuery)
            ->union($linestringQuery)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Получить геометрию элементов по ИД слоя
     * @param int $layerId
     * @return Collection
     */
    public function getByLayerId(int $layerId)
    {
        $pointQuery = $this->point
            ->select(DB::raw(
                'geo_points.created_at, geo_points.element_id, geo_points.id, geo_points.title, geo_points.layer_composition_id, 
                NULL as length, NULL as area, NULL as perimeter,
                address.city, address.street, address.build,
                ST_AsText(geo_points.geom) as geom, \'point\' as type'
            ))
            ->leftJoin('address', 'address.id', '=', 'geo_points.address_id')
            ->join('geo_elements', 'geo_elements.id', '=', 'geo_points.element_id')
            ->where('geo_elements.layer_id', $layerId);

        $linestringQuery = $this->linestring
            ->select(DB::raw(
                'geo_linestrings.created_at, geo_linestrings.element_id, geo_linestrings.id, geo_linestrings.title, geo_linestrings.layer_composition_id,
                geo_linestrings.length, NULL as area, NULL as perimeter,
                address.city, address.street, address.build,
                ST_AsText(geo_linestrings.geom) as geom, \'linestring\' as type'))
            ->leftJoin('address', 'address.id', '=', 'geo_linestrings.address_id')
            ->join('geo_elements', 'geo_elements.id', '=', 'geo_linestrings.element_id')
            ->where('geo_elements.layer_id', $layerId);

        return $this->polygon
            ->select(DB::raw(
                'geo_polygons.created_at, geo_polygons.element_id, geo_polygons.id, geo_polygons.title, geo_polygons.layer_composition_id,
                NULL as length, geo_polygons.area, geo_polygons.perimeter,
                address.city, address.street, address.build,
                ST_AsText(geo_polygons.geom) as geom, \'polygon\' as type'))
            ->leftJoin('address', 'address.id', '=', 'geo_polygons.address_id')
            ->join('geo_elements', 'geo_elements.id', '=', 'geo_polygons.element_id')
            ->where('geo_elements.layer_id', $layerId)
            ->union($pointQuery)
            ->union($linestringQuery)
            ->orderBy('created_at', 'asc')
            ->get();
    }


}
