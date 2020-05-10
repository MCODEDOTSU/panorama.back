<?php

namespace App\src\Services\Parser\Grids;

class SupportsGrid
{
    private $tableName = 'constructed_2';

    /**
     * Starting of data after excel header
     * @var int
     */
    public $contentStartingRowPosition = 3;

    /**
     * Basic column. Parsing will stop if this column will be empty
     * @var string
     */
    public $mainColumn = 'title';

    /**
     * TODO: нужно предусмотреть механизм не просто определения по отдельной ячейке, а к примеру по смежным
     * @var array
     */
    private $grid = [
        'title' => 'C', // main title which is stored in geo_elements table
        'address' => 'E',
        'organization_name' => 'A',
        'allocation_type' => 'F',
        'places_for_nodes_quantity' => 'G',
        'allocations_quantity' => 'H',
        'transfered_places_quantity' => 'I',
        'transfered_places_quantity_before_2018' => 'J',
        'transfered_places_quantity_after_2019' => 'K',
        'status' => 'L',
        'changes_impl_month' => 'M',
    ];

    public function getGrid() {
        return $this->grid;
    }

    /**
     * Наименование таблицы для хранения распарсенных данных
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }


}
