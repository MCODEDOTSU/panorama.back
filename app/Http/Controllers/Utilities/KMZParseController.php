<?php

namespace App\Http\Controllers\Utilities;

use App\Http\Controllers\Controller;
use App\src\Utilities\KMZParser\KMZParserService;
use Chumper\Zipper\Zipper;
use Exception;
use Illuminate\Http\Request;

class KMZParseController extends Controller
{
    private const KMZ_FILE_NAME = 'kmz.zip';
    private const STORAGE_FOLDER = 'kmzs';
    private const KML_EXTRACTION_FOLDER = 'extracted/kmz';

    private $kmzParserService;

    /**
     * KMZParseController constructor.
     * @param KMZParserService $KMZParserService
     */
    public function __construct(KMZParserService $KMZParserService)
    {
        $this->kmzParserService = $KMZParserService;
    }

    public function parse(Request $request)
    {
        // Upload file
        $kmzPath = $request->kmz->storeAs(self::STORAGE_FOLDER, self::KMZ_FILE_NAME);

        // unpack it
        try {
            (new Zipper)->make('../storage/app/' . $kmzPath)->extractTo(self::KML_EXTRACTION_FOLDER);
        } catch (Exception $e) {
            return response("KMZ file has not been found");
        }

        // parse KML
        $kmlsCollection = $this->kmzParserService->parse(public_path() . '/extracted/kmz/doc.kml');

        $this->kmzParserService->storeKmls($kmlsCollection, (int)$request->layerId);

        return response("kmz has been processed");
    }

}
