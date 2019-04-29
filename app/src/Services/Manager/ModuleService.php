<?php

namespace App\src\Services\Manager;

use App\src\Repositories\Manager\ModuleRepository;
use Illuminate\Http\Request;

class ModuleService
{
    protected $moduleRepository;

    /**
     * ModuleService constructor.
     * @param ModuleRepository $moduleRepository
     */
    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }

    /**
     * Получить все модули.
     * @return \Illuminate\Support\Collection
     */
    public function getAll()
    {
        return $this->moduleRepository->getAll();
    }

    /**
     * Изменить модуль.
     * @param int $id
     * @param Request $data
     * @return \App\src\Models\Module
     */
    public function update(int $id, Request $data)
    {
        return $this->moduleRepository->update($id, $data);
    }

    /**
     * Создать модуль.
     * @param Request $data
     * @return \App\src\Models\Module
     */
    public function create(Request $data)
    {
        return $this->moduleRepository->create($data);
    }

    /**
     * Удалить модуль.
     * @param int $id
     * @return array
     */
    public function delete(int $id)
    {
        return $this->moduleRepository->delete($id);
    }

}
