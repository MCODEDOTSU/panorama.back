<?php

namespace App\src\Services\Geo;

use App\src\Repositories\Info\ContractorRepository;
use App\src\Repositories\Geo\LayerRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Class LayerService
 * @package App\src\Services\Geo
 */
class LayerService
{
    protected $layerRepository;
    protected $contractorRepository;

    /**
     * LayerService constructor.
     * @param LayerRepository $layerRepository
     */
    public function __construct(LayerRepository $layerRepository, ContractorRepository $contractorRepository)
    {
        $this->layerRepository = $layerRepository;
        $this->contractorRepository = $contractorRepository;
    }

    /**
     * Получить все слои
     * @return Collection
     */
    public function getLayers(): Collection
    {
        $layers = $this->layerRepository->getLayers();
        foreach ($layers as $i => $layer) {
            $elements = [];
            foreach ($layer->elements as $element) {
                $elements[$element->id] = $element;
            }
            $layers[$i] = [
                'id' => $layer->id,
                'title' => $layer->title,
                'description' => $layer->description,
                'parent_id' => $layer->parent_id,
                'module_id' => $layer->module_id,
                'alias' => $layer->alias,
                'elements' => $elements,
                'composition' => $layer->composition
            ];
        }
        return $layers;
    }

    /**
     * Получить слои для редактивроания.
     * @return Collection
     */
    public function getManagerLayers(): Collection
    {
        $authedUser = Auth::user();

        // Контрагент
        $authedUser->contractor = $authedUser->contractor()->first();
        $contractor = $this->contractorRepository->getById($authedUser->contractor_id);

        $layers = $this->layerRepository->getManagerLayers($contractor->id);
        foreach ($layers as $i => $layer) {
            $elements = [];
            foreach ($layer->elements as $element) {
                $elements[$element->id] = $element;
            }
            $layers[$i] = [
                'id' => $layer->id,
                'title' => $layer->title,
                'description' => $layer->description,
                'parent_id' => $layer->parent_id,
                'module_id' => $layer->module_id,
                'alias' => $layer->alias,
                'elements' => $elements,
                'composition' => $layer->composition
            ];
        }
        return $layers;
    }

    /**
     * Получить все слои модуля
     * @param $moduleId
     * @return Collection
     */
    public function getLayersByModule($moduleId): Collection
    {
        return $this->layerRepository->getLayersByModule($moduleId);
    }

}
