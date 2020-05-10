<?php

namespace App\src\Utilities\ZIPRenderer;

use Chumper\Zipper\Zipper;
use Exception;

class ZipRendererService
{
    private const KMZ_FILE_NAME = 'kmz.zip';
    private const STORAGE_FOLDER = 'kmzs';
    private const KML_EXTRACTION_FOLDER = 'extracted/kmz';

    /**
     * @param $kmz => kmz file
     * @return void
     * @throws Exception
     */
    public function unzipFile($kmz): void
    {
        // Upload file
        $kmzPath = $kmz->storeAs(self::STORAGE_FOLDER, self::KMZ_FILE_NAME);

        // unpack it
        (new Zipper)->make('../storage/app/' . $kmzPath)->extractTo(self::KML_EXTRACTION_FOLDER);
    }
}
