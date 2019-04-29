<?php

namespace App\src\Repositories\Manager;
use App\src\Models\Module;
use Illuminate\Support\Collection;

class ModuleRepository
{
    protected $module;

    /**
     * ModuleRepository constructor.
     * @param $module
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * Получить модуль по ИД.
     * @param $id
     * @return Module
     */
    public function getById($id): Module
    {
        return $this->module->find($id);
    }

    /**
     * Список всех модулей.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->module
            ->with('layers')
            ->with('contractors')
            ->get();
    }


    /**
     * Обновить модуль.
     * @param int $id
     * @param $data
     * @return Module
     */
    public function update(int $id, $data)
    {
        $record = $this->module::find($id);
        $record->title = $data->title;
        $record->description = $data->description;
        $record->save();
        return $record;
    }

    /**
     * Создать модуль.
     * @param $data
     * @return Module
     */
    public function create($data): Module
    {
        return $this->module->create([
            'title' => $data->title,
            'description' => $data->description
        ]);
    }

    /**
     * Удалить модуль.
     * @param $id
     * @return array
     */
    public function delete(int $id)
    {
        $record = $this->module::find($id);
        $record->delete();
        return ['id' => $id];
    }

}
