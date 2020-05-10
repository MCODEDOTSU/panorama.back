<?php

namespace App\src\Services\Parser;

use App\src\Repositories\Parser\ParserRepository;
use App\src\Services\Parser\Grids\SupportsGrid;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\src\Repositories\Manager\ElementRepository;

class ParserService
{
    private $parserGrid;
    private $parserRepository;
    private $elementRepository;

    /**
     * ParserService constructor.
     * TODO: Вмемсто SupportsGrid - будет механизм резолвера Сетки (Grid) для выбора нужной
     * @param SupportsGrid $parserGrid
     * @param ParserRepository $parserRepository
     * @param ElementRepository $elementRepository
     */
    public function __construct(SupportsGrid $parserGrid, ParserRepository $parserRepository, ElementRepository $elementRepository)
    {
        $this->parserGrid = $parserGrid;
        $this->parserRepository = $parserRepository;
        $this->elementRepository = $elementRepository;
    }

    /**
     * Прочитать файл для последующего парсинга
     * @param $file
     * @throws \Exception
     */
    public function parse($file)
    {
        try {

            $reader = new Xlsx();
            $spreadsheet = $reader->load($file);

            $this->readCells($spreadsheet);

        } catch (Exception $e) {
            throw new \Exception('Something went wrong with file while processing');
        }
    }

    /**
     * Прочитать ячейки, схема которых берется из папки Grids (описание для парсинга)
     * @param Spreadsheet $spreadSheet
     * @throws \Exception
     */
    private function readCells(SpreadSheet $spreadSheet)
    {
        try {
            $sheets = $spreadSheet->getAllSheets();

            if (!isset($sheets[0])) {
                throw new \Exception('At least one spreadsheet has to be available');
            }

            $firstSheet = $sheets[0];

            do {
                $rowData = $this->readRow($firstSheet);
                $this->parserGrid->contentStartingRowPosition++;

                // Store parsed data in DB
                $this->storeParsedInfo($rowData);

            } while ($rowData[$this->parserGrid->mainColumn] != null);


        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            throw new \Exception('Something went wrong with file while processing');
        }
    }


    /**
     * Parse single row from sheet
     * @param $sheet
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function readRow(Worksheet $sheet)
    {
        $rowData = [];

        foreach ($this->parserGrid->getGrid() as $cellKey => $singleCell) {
            $cellVal = $sheet->getCell($singleCell.$this->parserGrid->contentStartingRowPosition)->getCalculatedValue();
            $rowData[$cellKey] = $cellVal;
        }

        return $rowData;
    }

    /**
     * TODO: Just make it simpler and improve logic
     * @param $rowData
     */
    private function storeParsedInfo(array $rowData)
    {
        $elementData = new \stdClass();
        $elementData->layer_id = 2;
        $elementData->title = $rowData['title'];
        $elementData->description = $rowData['title'];
        $element = $this->elementRepository->create($elementData);

        unset($rowData['title']);

        $rowData['element_id'] = $element->id;

        $this->parserRepository->persist($rowData);
    }
}
