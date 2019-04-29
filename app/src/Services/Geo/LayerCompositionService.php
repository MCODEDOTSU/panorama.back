<?php

namespace App\src\Services\Geo;

use App\src\Repositories\Geo\LayerCompositionRepository;
use Illuminate\Support\Collection;

/**
 * Class LayerCompositionService
 * @package App\src\Services\Geo
 */
class LayerCompositionService
{
    protected $layerCompositionRepository;

    /**
     * LayerCompositionService constructor.
     * @param LayerCompositionRepository $layerCompositionRepository
     */
    public function __construct(LayerCompositionRepository $layerCompositionRepository)
    {
        $this->layerCompositionRepository = $layerCompositionRepository;
    }

    /**
     * Получить все композиции.
     * @return Collection
     */
    public function getAll(): Collection
    {
        $compositions = $this->layerCompositionRepository->getAll();
        foreach ($compositions as &$composition) {
            $composition->style = json_decode($composition->style);
        }
        return $compositions;
    }

    /**
     * Получить все композиции слоя.
     * @return Collection
     */
    public function getLayerCompositions($layerId): Collection
    {
        return $this->layerCompositionRepository->getLayerCompositions($layerId);
    }

}
