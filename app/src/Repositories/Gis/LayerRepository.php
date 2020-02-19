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
                    $query->select(DB::raw('*, ST_AsText(geometry) as geometry'))->orderBy('title', 'asc');
                }
            ])
            ->where('visibility', true)
            ->get();
    }

    /**
     * Получить несколько слоёв
     * @param $layerIds
     * @return Collection
     */
    public function getFewById($layerIds): Collection
    {
        return $this->layer
            ->with([
                'elements' => function($query) {
                    $query->select(DB::raw('*, ST_AsText(geometry) as geometry'))->orderBy('title', 'asc');
                }
            ])
            ->whereIn('id', $layerIds)
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
                    $query->select(DB::raw('*, ST_AsText(geometry) as geometry'))->orderBy('title', 'asc');
                }
            ])
            ->whereHas('module', function ($query) use ($contractorId) {
                $query->whereHas('contractors', function ($query) use ($contractorId) {
                    $query->where('contractor_id', '=', $contractorId);
                });
            })
            ->get();
    }

}
