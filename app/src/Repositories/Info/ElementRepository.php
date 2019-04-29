<?php

namespace App\src\Repositories\Info;


use App\src\Models\Element;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ElementRepository
{
    protected $element;

    /**
     * ElementRepository constructor.
     * @param $element
     */
    public function __construct(Element $element)
    {
        $this->element = $element;
    }

    /**
     * Получить все элементы слоя
     * @param $layerId
     * @return Collection
     */
    public function getElementsByLayer($layerId): Collection
    {
        return $this->element
            ->where('layer_id', $layerId)
            ->with('points')
            ->with('linestrings')
            ->with('polygons')
            ->get();
    }

    public function getById($id): Element
    {
        return $this->element->find($id);
    }

    public function update(Element $element, $data)
    {
        $element->title = $data->title;
        $element->description = $data->description;

        $element->save();

        return $element;
    }

    public function create($data)
    {
        $element = new Element;

        $element->title = $data->title;
        $element->description = $data->description;
        $element->layer_id = $data->layer_id;
        $element->visibility = $data->visibility;

        $element->save();

        return $element;
    }

    public function delete($id)
    {
        $element = $this->getById($id);
        $element->delete();
        return ['id' => $id];
    }

}
