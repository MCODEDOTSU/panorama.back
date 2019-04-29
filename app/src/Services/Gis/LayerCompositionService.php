<?php

namespace App\src\Services\Gis;
use App\src\Repositories\Gis\LayerCompositionRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class LayerCompositionService
 * @package App\src\Services\Gis
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
     * Список состава слоёв.
     * @return \Illuminate\Support\Collection
     */
    public function getAll()
    {
        return $this->layerCompositionRepository->getAll();
    }

    /**
     * Список состава слоёв для контрагента.
     * @return \Illuminate\Support\Collection
     */
    public function getAllToContractor()
    {
        $user = Auth::user();
        return $this->layerCompositionRepository->getAllToContractor($user->contractor_id);
    }

}
