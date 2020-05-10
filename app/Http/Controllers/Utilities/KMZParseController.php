<?php

namespace App\Http\Controllers\Utilities;

use App\Http\Controllers\Controller;
use App\src\Utilities\KMZParser\KMZParserService;
use App\src\Utilities\ZIPRenderer\ZipRendererService;
use Exception;
use Illuminate\Http\Request;

class KMZParseController extends Controller
{
    private const KML_EXTRACTION_FOLDER = 'extracted/kmz';
    private const KML_FILE_NAME = '/doc.kml';

    private $kmzParserService;
    private $zipRendererService;

    /**
     * KMZParseController constructor.
     * @param KMZParserService $KMZParserService
     * @param ZipRendererService $zipRendererService
     */
    public function __construct(KMZParserService $KMZParserService, ZipRendererService $zipRendererService)
    {
        $this->kmzParserService = $KMZParserService;
        $this->zipRendererService = $zipRendererService;
    }

    public function parse(Request $request)
    {
        // unzip kml
        try {
            $this->zipRendererService->unzipFile($request->kmz);
        } catch (Exception $e) {
            return response($e->getMessage());
        }

        // parse KML
        $kmlsCollection = $this->kmzParserService->parse(public_path() . '/' . self::KML_EXTRACTION_FOLDER . self::KML_FILE_NAME);

        $this->kmzParserService->storeKmls($kmlsCollection, (int)$request->layerId);

        return response("kmz has been processed");
    }

}
