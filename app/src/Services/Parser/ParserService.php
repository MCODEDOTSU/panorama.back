<?php

namespace App\src\Services\Parser;

use App\src\Repositories\Parser\ParserRepository;
use App\src\Services\Parser\Grids\SupportsGrid;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParserService
{
    private $parserGrid;
    private $parserRepository;

    /**
     * ParserService constructor.
     * TODO: Вмемсто SupportsGrid - будет механизм рехолвера Сетки (Grid) для выбора нужной
     * @param SupportsGrid $parserGrid
     * @param ParserRepository $parserRepository
     */
    public function __construct(SupportsGrid $parserGrid, ParserRepository $parserRepository)
    {
        $this->parserGrid = $parserGrid;
        $this->parserRepository = $parserRepository;
    }

    /**
     * Прочитать файл для последующего парсинга
     * @param $file
     * @return string
     */
    public function parse($file)
    {
        try {

            $reader = new Xlsx();
            $spreadsheet = $reader->load($file);

            $this->readCells($spreadsheet);

        } catch (Exception $e) {
            return 'Something went wrong with file while processing';
        }
    }

    /**
     * Прочитать ячейки, схема которых берется из папки Grids (описание для парсинга)
     * @param Spreadsheet $spreadSheet
     * @return string
     */
    private function readCells(SpreadSheet $spreadSheet)
    {
        try {
            $sheets = $spreadSheet->getAllSheets();
            $firstSheet = $sheets[0];

            do {
                $rowData = $this->readRow($firstSheet);
                $this->parserGrid->contentStartingRowPosition++;

                // Store parsed data in DB
                $this->parserRepository->persist($rowData);

            } while ($rowData[$this->parserGrid->mainColumn] != null);


        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            return 'Something went wrong with file while processing';
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
}
