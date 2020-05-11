<?php

namespace App\Http\Controllers\Utilities;

use App\src\Services\Parser\ParserService;
use Illuminate\Http\Request;

class XLSParseController
{
    private const STORAGE_FOLDER = 'xlss';
    private const XLS_FILE_NAME = '/file.xlsx';

    private $parserService;

    public function __construct(ParserService $parserService)
    {
        $this->parserService = $parserService;
    }

    public function parse(Request $request)
    {
        // Upload file
        $xlsPath = $request->xls->storeAs(self::STORAGE_FOLDER, self::XLS_FILE_NAME);

        try {
            $xlsFilePath = '../storage/app/' . $xlsPath;

            $this->parserService->parse($xlsFilePath);

        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }
    }
}
