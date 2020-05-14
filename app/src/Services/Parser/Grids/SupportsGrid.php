<?php

namespace App\src\Services\Parser\Grids;

use App\src\Repositories\Constructor\AdditionalInfoRepository;
use App\src\Repositories\Manager\ElementRepository;
use App\src\Services\Parser\Entities\BasicGrid;
use App\src\Services\Parser\Entities\Cell;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\src\Models\Element;


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
    public $mainColumn = 'combined_title';

    /**
     * @var BasicGrid
     */
    private $grid;

    // Injections
    private $elementRepository;
    private $additionalInfoRepository;

    /**
     * SupportsGrid constructor.
     * @param ElementRepository $elementRepository
     * @param AdditionalInfoRepository $additionalInfoRepository
     */
    public function __construct(ElementRepository $elementRepository, AdditionalInfoRepository $additionalInfoRepository)
    {
        $this->grid = new BasicGrid([
           new Cell('combined_title', 'B', false),
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

        $this->elementRepository = $elementRepository;
        $this->additionalInfoRepository = $additionalInfoRepository;
    }


    /**
     * @return Cell[]
     */
    public function getGrid(): array
    {
        return $this->grid->cells;
    }

    /**
     * DB table name for parsed data
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

    /**
     * Get unique title based on 'opory' and 'pitayushchiye-punkty' layers
     * Excel cells: combined_title -> B, title -> C
     * Linked column is 'opora'
     * @param WorkSheet $sheet
     * @return int|mixed
     * @throws Exception
     */
    public function getUniqueTitle(WorkSheet $sheet)
    {
        $cellNameComparator = function ($title) {
            return function ($cell) use ($title) { return $cell->name == $title; };
        };

        // 1. Find: try to find 'opory' with such title (There can be several of them)
        $titleColFilter = array_filter($this->getGrid(), $cellNameComparator('title'));
        $titleCol = array_pop($titleColFilter)->column;
        $titleCellVal = $sheet->getCell($titleCol.$this->contentStartingRowPosition)->getValue();
        if (!$titleCellVal) {
            return false;
        }
        /** @var Element[] $elements */
        $elements = $this->elementRepository->getByTitle($titleCellVal);

        // 2. Find: 'pitayushchiye-punkty' which are linked based on linking column
        $baseTitleColFilter = array_filter($this->getGrid(), $cellNameComparator('combined_title'));
        $baseTitleCol= array_pop($baseTitleColFilter)->column;
        $baseTitleCellVal = $sheet->getCell($baseTitleCol.$this->contentStartingRowPosition)->getValue();

        foreach ($elements as $element) {
            $additionalInfoForElement = $this->additionalInfoRepository->getAdditionalInfo(
                $this->tableName, $element->id);

            if (!$additionalInfoForElement) {
                return false;
            }

            $feedingPoint = $this->elementRepository->getById($additionalInfoForElement->opora);
            // 3. If they coincide -> return elementId of 'tableName' which will be updated
            if ($baseTitleCellVal == $feedingPoint->title) {
                return $additionalInfoForElement;
            }
        }

        return false;
    }


}
