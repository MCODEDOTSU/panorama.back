<?php

namespace App\Http\Controllers\Utilities;

use App\Http\Controllers\Controller;
use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;
use ZipArchive;

class KMZParseController extends Controller
{
    private const KMZ_FILE_NAME = 'kmz.zip';
    private const STORAGE_FOLDER = 'kmzs';
    private const KML_EXTRACTION_FOLDER = 'extracted/kmz';

    public function parse(Request $request)
    {
        // Upload file
        $kmzPath = $request->kmz->storeAs(self::STORAGE_FOLDER, self::KMZ_FILE_NAME);

        // unpack it
        (new Zipper)->make('../storage/app/'.$kmzPath)->extractTo(self::KML_EXTRACTION_FOLDER);

        // get kml

        // parse KML

        return response("kmz has been processed");
    }
}
