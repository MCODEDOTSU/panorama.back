<?php

namespace App\src\Repositories\Geo;

use App\src\Models\LayerComposition;
use Illuminate\Support\Collection;

/**
 * Class LayerCompositionRepository
 * @package App\src\Repositories\Geo
 */
class LayerCompositionRepository
{
    protected $layerComposition;

    /**
     * LayerCompositionRepository constructor.
     * @param $layerComposition
     */
    public function __construct(LayerComposition $layerComposition)
    {
        $this->layerComposition = $layerComposition;
    }

    /**
     * Получить все композиции.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->layerComposition->get()->keyBy('id');
    }

    /**
     * Получить все композиции слоя
     * @return Collection
     */
    public function getLayerCompositions($layerId): Collection
    {
        return $this->layerComposition
            ->where('layer_id', $layerId)
            ->get();
    }

    /**
     * Получить композицию по ИД
     * @param $id
     * @return LayerComposition
     */
    public function getById($id): LayerComposition
    {
        return $this->layerComposition->find($id);
    }

    public function getByLayerAndGeom($geometry, $layerId): LayerComposition
    {
        return $this->layerComposition
            ->where([
                'layer_id' => $layerId,
                'geometry_type' => $geometry
            ])->first();
    }

}
