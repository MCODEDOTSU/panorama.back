<?php

namespace App\src\Repositories\Manager;
use App\src\Models\Layer;
use Illuminate\Support\Collection;

/**
 * Class LayerRepository
 * @package App\src\Repositories\Manager
 */
class LayerRepository
{
    protected $layer;

    /**
     * LayerRepository constructor.
     * @param $layer
     */
    public function __construct(Layer $layer)
    {
        $this->layer = $layer;
    }

    /**
     * Список всех слоёв.
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->layer
            ->with('module')
            ->with('parent')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Список слоёв для контрагента.
     * @param $contractorId
     * @param $parentContractorId
     * @return Collection
     */
    public function getAllToContractor($contractorId, $parentContractorId): Collection
    {
        return $this->layer
            ->with('module')
            ->with('elements')
            ->whereHas('module', function ($query) use ($contractorId, $parentContractorId) {
                $query->whereHas('contractors', function ($query) use ($contractorId, $parentContractorId) {
                    $query->whereIn('contractor_id', [$contractorId, $parentContractorId]);
                });
            })
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Получить все слои указанного типа
     * @param string $type
     * @return ResponseFactory|Response
     */
    public function getByType(string $type)
    {
        return $this->layer
            ->where('geometry_type', $type)
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * Получить слой по ИД.
     * @param $id
     * @return Layer
     */
    public function getById(int $id): Layer
    {
        return $this->layer
            ->with('module')
            ->with('parent')
            ->where('id', $id)
            ->first();
    }

    /**
     * Обновить слой.
     * @param int $id
     * @param $data
     * @return Layer
     */
    public function update(int $id, $data)
    {
        $record = $this->getById($id);
        $record->alias = $data->alias;
        $record->title = $data->title;
        $record->description = $data->description;
        if($data->parent_id != 0) {
            $record->parent_id = $data->parent_id;
        } else {
            $record->parent_id = null;
        }
        $record->module_id = $data->module_id;
        $record->visibility = $data->visibility;
        $record->geometry_type = $data->geometry_type;
        $record->style = $data->style;
        $record->save();
        return $record;
    }

    /**
     * Создать слой.
     * @param $data
     * @return Layer
     */
    public function create($data): Layer
    {
        $recordData = [
            'alias' => $data->alias,
            'title' => $data->title,
            'description' => $data->description,
            'module_id' => $data->module_id,
            'visibility' => $data->visibility,
            'geometry_type' => $data->geometry_type,
            'style' => $data->style,
        ];
        if($data->parent_id !== 0) {
            $recordData['parent_id'] = $data->parent_id;
        }
        $record = $this->layer->create($recordData);
        return $this->getById($record->id);
    }

    /**
     * Удалить слой.
     * @param $id
     * @return array
     */
    public function delete(int $id)
    {
        $record = $this->layer::find($id);
        $record->delete();
        return ['id' => $id];
    }

}
