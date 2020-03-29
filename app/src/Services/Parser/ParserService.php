<?php

namespace App\src\Services\Parser;

use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ParserService
{
    public function parse($file)
    {
        try {

            $reader = new Xlsx();
            $spreadsheet = $reader->load($file);
            $this->readCells($spreadsheet);

        } catch (Exception $e) {
            return 'Something went wrong with file processing';
        }

    }

    private function readCells(SpreadSheet $spreadSheet)
    {

        try {
            $sheets = $spreadSheet->getAllSheets();

            $firstSheet = $sheets[0];

            $ppNumberCell = $firstSheet->getCell('B2');

            dd($ppNumberCell->getValue());

        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            return 'Something went wrong with file processing';
        }

    }
}
