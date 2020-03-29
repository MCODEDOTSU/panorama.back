<?php

namespace App\Http\Controllers\Parser;

use App\src\Services\Parser\ParserService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ParserController
{
    private $parserService;

    public function __construct(ParserService $parserService)
    {
        $this->parserService = $parserService;
    }

    public function parse(Request $request)
    {
        try {

            $inputFileName = 'C:\My\Work\OSPanel\domains\panorama.back\parser_example.xlsx';

            $this->parserService->parse($inputFileName);

        } catch (Exception $e) {
            return response('Something went wrong with file processing', 400);
        }
    }
}
