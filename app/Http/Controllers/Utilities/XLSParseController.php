<?php

namespace App\Http\Controllers\Utilities;

use App\src\Services\Parser\ParserService;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class XLSParseController
{
    private const STORAGE_FOLDER = 'xlss';
    private const XLS_FILE_NAME = '/file.xlsx';

    private $parserService;

    public function __construct(ParserService $parserService)
    {
        $this->parserService = $parserService;
    }

    /**
     * @param Request $request:
     * xls - file for parsing
     * layerId - place for storing geo_elements
     * @return ResponseFactory|Application|Response
     * @throws Exception
     */
    public function parse(Request $request)
    {
        // Upload file
        $xlsPath = $request->xls->storeAs(self::STORAGE_FOLDER, self::XLS_FILE_NAME);

        try {
            $xlsFilePath = '../storage/app/' . $xlsPath;

            // define layer for parsing
            $this->parserService->getParserGrid()->setLayerForGeoElements($request->layerId);

            // parse
            $this->parserService->parse($xlsFilePath);

        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }
    }
}
