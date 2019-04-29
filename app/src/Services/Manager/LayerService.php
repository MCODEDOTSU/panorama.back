<?php

namespace App\src\Services\Manager;
use App\src\Models\Layer;
use App\src\Repositories\Manager\LayerRepository;
use Illuminate\Http\Request;

/**
 * Class LayerService
 * @package App\src\Services\Manager
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
     * Получить все слои.
     * @return \Illuminate\Support\Collection
     */
    public function getAll()
    {
        return $this->layerRepository->getAll();
    }

    /**
     * Получить слой по ИД
     * @param int $id
     * @return \App\src\Models\Layer
     */
    public function getById(int $id): Layer
    {
        return $this->layerRepository->getById($id);
    }

    /**
     * Изменить слой.
     * @param int $id
     * @param Request $data
     * @return \App\src\Models\Layer
     */
    public function update(int $id, Request $data)
    {
        return $this->layerRepository->update($id, $data);
    }

    /**
     * Создать слой.
     * @param Request $data
     * @return \App\src\Models\Layer
     */
    public function create(Request $data)
    {
        return $this->layerRepository->create($data);
    }

    /**
     * Удалить слой.
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->layerRepository->delete($id);
    }

}
