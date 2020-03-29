<?php

namespace App\Http\Controllers\Parser;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ParserController
{
    public function parse(Request $request)
    {
        try {

            $inputFileName = 'C:\My\Work\OSPanel\domains\panorama.back\parser_example.xlsx';

            $reader = new Xlsx();

            $spreadsheet = $reader->load($inputFileName);

            $this->readCells($spreadsheet);

        } catch (Exception $e) {
            return response('Something went wrong with file processing', 400);
        }
    }

    private function readCells(SpreadSheet $spreadSheet)
    {
        $sheets = $spreadSheet->getAllSheets();

        $firstSheet = $sheets[0];

        $ppNumberCell = $firstSheet->getCell('B2');

        dd($ppNumberCell->getValue());
    }
}
