<?php

namespace App\src\Services\Parser\Grids;

use App\src\Services\Parser\Entities\BasicGrid;
use App\src\Services\Parser\Entities\Cell;

class SupportsGrid
{
    private $tableName = 'constructed_0';
    public $layerId;

    /**
     * Starting of data after excel header
     * @var int
     */
    public $contentStartingRowPosition = 3;

    /**
     * Basic column. Parsing will use this column to compare title of Excel file and Parser mail column
     * @var string
     */
    public $mainColumn = 'title';

    /**
     * @var BasicGrid
     */
    private $grid;

    /**
     * SupportsGrid constructor.
     */
    public function __construct()
    {


        $this->grid = new BasicGrid([
           new Cell('title', 'C', false),
           new Cell('address', 'E', true),
           new Cell('organization_name', 'A', false),
           new Cell('allocation_type', 'F', false),
           new Cell('places_for_nodes_quantity', 'G', false),
           new Cell('allocations_quantity', 'H', false),
           new Cell('transfered_places_quantity', 'I', false),
           new Cell('transfered_places_quantity_before_2018', 'J', false),
           new Cell('transfered_places_quantity_after_2019', 'K', false),
           new Cell('status', 'L', false),
           new Cell('changes_impl_month', 'M', false),
        ]);
    }


    /**
     * @return Cell[]
     */
    public function getGrid(): array
    {
        return $this->grid->cells;
    }

    /**
     * Наименование таблицы для хранения распарсенных данных
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * Define layer for further inserting into geo_elements
     * @param $layerId
     */
    public function setLayerForGeoElements($layerId)
    {
        $this->tableName = 'constructed_'.$layerId;
        $this->layerId = $layerId;
    }


}
