<?php

namespace App\src\Services\Gis;
use App\src\Repositories\Gis\LayerRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class LayerService
 * @package App\src\Services\Gis
 */
class LayerService
{
    protected $layerRepository;

    /**
     * LayerService constructor.
     * @param LayerRepository $layerRepository
     */
    public function __construct(LayerRepository $layerRepository)
    {
        $this->layerRepository = $layerRepository;
    }

    /**
     * Список всех слоёв
     * @return \Illuminate\Support\Collection
     */
    public function getAll()
    {
        return $this->layerRepository->getAll();
    }

    /**
     * Получить все слои для контрагента.
     * @return \Illuminate\Support\Collection
     */
    public function getAllToContractor()
    {
        $user = Auth::user();
        return $this->layerRepository->getAllToContractor($user->contractor_id);
    }

}
