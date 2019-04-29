<?php

namespace App\src\Repositories\Manager;
use App\src\Models\LayerComposition;
use Illuminate\Support\Collection;

/**
 * Class LayerCompositionRepository
 * @package App\src\Repositories\Manager
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
     * Получить композицию слоя по ИД.
     * @param $id
     * @return LayerComposition
     */
    public function getById($id): LayerComposition
    {
        return $this->layerComposition
            ->with('layer')
            ->where('id', $id)
            ->first();
    }

    /**
     * Список состава слоя.
     * @param $layerId
     * @return Collection
     */
    public function getAll($layerId): Collection
    {
        return $this->layerComposition
            ->with('layer')
            ->where('layer_id', $layerId)
            ->get();
    }

    /**
     * Обновить композицию.
     * @param int $id
     * @param $data
     * @return LayerComposition
     */
    public function update(int $id, $data)
    {
        $record = $this->getById($id);
        $record->title = $data->title;
        $record->description = $data->description;
        $record->geometry_type = $data->geometry_type;
        $record->style = $data->style;
        $record->save();
        return $record;
    }

    /**
     * Создать композицию слоя.
     * @param $data
     * @return LayerComposition
     */
    public function create($data): LayerComposition
    {
        $record = $this->layerComposition->create([
            'layer_id' => $data->layer_id,
            'title' => $data->title,
            'description' => $data->description,
            'geometry_type' => $data->geometry_type,
            'style' => $data->style,
        ]);
        return $this->getById($record->id);
    }

    /**
     * Удалить композицию.
     * @param $id
     * @return array
     */
    public function delete(int $id)
    {
        $record = $this->layerComposition::find($id);
        $record->delete();
        return ['id' => $id];
    }

}
