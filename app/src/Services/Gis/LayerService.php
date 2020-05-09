<?php

namespace App\src\Services\Gis;
use App\src\Models\Layer;
use App\src\Repositories\Gis\LayerRepository;
use Illuminate\Support\Collection;
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
     * @return Collection
     */
    public function getAll()
    {
        return $this->layerRepository->getAll();
    }

    /**
     * Получить несколько слоёв
     * @param $layerIds
     * @return Collection
     */
    public function getFewById($layerIds)
    {
        return $this->layerRepository->getFewById($layerIds);
    }

    /**
     * Получить все слои для контрагента.
     * @return Collection
     */
    public function getAllToContractor()
    {
        $user = Auth::user();
        return $this->layerRepository->getAllToContractor($user->contractor_id);
    }

    /**
     * Получить слой по алиасу
     * @param string $alias
     * @return Layer
     */
    public function getByAlias(string $alias)
    {
        return $this->layerRepository->getByAlias($alias);
    }

}
