<?php

namespace App\src\Repositories\Manager;
use App\src\Models\ElementGraph;
use Illuminate\Support\Facades\DB;

/**
 * Class ElementGraphRepository
 * @package App\src\Repositories\Gis
 */
class ElementGraphRepository
{
    protected $elementGraph;

    /**
     * ElementGraphRepository constructor.
     * @param ElementGraph $elementGraph
     */
    public function __construct(ElementGraph $elementGraph)
    {
        $this->elementGrap = $elementGraph;
    }

    /**
     * Получить связь с предыдущим элементом
     * @param $element_id
     * @return ElementGraph
     */
    public function getPrevious($element_id)
    {
        return $this->elementGrap
            ->with([
                'element' => function($query) {
                    $query->select(DB::raw('*, ST_AsText(geometry) as geometry'))->orderBy('title', 'asc');
                }
            ])
            ->where('next_element_id', $element_id)
            ->first();
    }

    /**
     * Получить связи со слующими элементами
     * @param $element_id
     * @return ElementGraph[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getNext($element_id)
    {
        return $this->elementGrap
            ->with([
                'next_element' => function($query) {
                    $query->select(DB::raw('*, ST_AsText(geometry) as geometry'))->orderBy('title', 'asc');
                }
            ])
            ->where('element_id', $element_id)
            ->get();
    }

    /**
     * Создать
     * @param $data
     * @return ElementGraph
     */
    public function create($data): ElementGraph
    {
        return $this->elementGrap->create([
            'element_id' => $data['element_id'],
            'next_element_id' => $data['next_element_id'],
        ]);
    }

    /**
     * Изменить
     * @param int $id
     * @param $data
     * @return ElementGraph
     */
    public function update(int $id, $data): ElementGraph
    {
        $record = $this->elementGrap->find($id);
        $record->element_id = $data['element_id'];
        $record->next_element_id = $data['next_element_id'];
        $record->save();
        return $record;
    }

    /**
     * Удалить
     * @param int $id
     * @return ElementGraph
     */
    public function delete(int $id): ElementGraph
    {
        $record = $this->elementGrap->find($id);
        $record->delete();
        return $record;
    }

    /**
     * Удалить все связи для элемента
     * @param int $element_id
     * @return void
     */
    public function deleteAll(int $element_id)
    {
        $this->elementGrap->where('element_id', $element_id)->delete();
        $this->elementGrap->where('next_element_id', $element_id)->delete();
    }


}
