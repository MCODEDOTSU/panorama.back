<?php

namespace App\src\Services\Parser;

use App\src\Repositories\Parser\ParserRepository;
use App\src\Services\Parser\Grids\ExampleParserGrid;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ParserService
{
    private $parserGrid;
    private $parserRepository;

    public function __construct(ExampleParserGrid $parserGrid, ParserRepository $parserRepository)
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

            $sheetData = [];

            foreach ($this->parserGrid->getGrid() as $cellKey => $singleCell) {

                $cellVal = $firstSheet->getCell($singleCell)->getValue();
                $sheetData[$cellKey] = $cellVal;
            }

            $this->parserRepository->persist($sheetData);

        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            return 'Something went wrong with file while processing';
        }

    }
}
