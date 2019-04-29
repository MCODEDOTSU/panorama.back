<?php

namespace App\src\Repositories\Gis;
use App\src\Models\LayerComposition;
use Illuminate\Support\Collection;

/**
 * Class LayerCompositionRepository
 * @package App\src\Repositories\Gis
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
     * Список состава слоёв.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->layerComposition->get();
    }

    /**
     * Список состава слоёв для контрагента.
     * @param int $contractorId
     * @return Collection
     */
    public function getAllToContractor(int $contractorId): Collection
    {
        return $this->layerComposition
            ->whereHas('layer', function ($query) use ($contractorId) {
                $query->whereHas('module', function ($query) use ($contractorId) {
                    $query->whereHas('contractors', function ($query) use ($contractorId) {
                        $query->where('contractor_id', '=', $contractorId);
                    });
                });
            })
            ->get();
    }

}
