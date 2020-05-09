<?php

namespace App\src\Utilities\KMZParser;

use App\src\Services\Gis\ElementService;
use App\src\Utilities\KMZParser\Entities\KMZElement;
use Illuminate\Support\Collection;

class KMZParserService
{
    /** @var ElementService */
    private $elementService;

    private $layerId;

    /**
     * KMZParserService constructor.
     * @param ElementService $elementService
     */
    public function __construct(ElementService $elementService)
    {
        $this->elementService = $elementService;

        $layerId = $this->defineKmzLayer();
    }

    public function parse($xmlPath)
    {
        $xmldata = simplexml_load_file($xmlPath);

        $childs = $xmldata->Document->Folder->children();

        $kmzCollection = new Collection();

        foreach ($childs as $child)
        {
            $childToArray = (array)$child;

            if (array_has($childToArray, 'name')) {
                $kmzElement = $this->parseSingleElement($childToArray);
                $kmzCollection->push($kmzElement);
            }
        }

        $this->storeKmls($kmzCollection);
    }

    private function parseSingleElement(array $childElement): KMZElement
    {
        $name = $childElement['name'];

        $coordinates = null;

        $issetPoint = isset($childElement['Point']);

        if ($issetPoint) {
            $point = (array)$childElement['Point'];
            $coordinates = $point['coordinates'];
        }

        return new KMZElement($name, $coordinates, 'POINT');
    }

    private function storeKmls(Collection $kmlCollection) {

        /** @var KMZElement $kml */
        foreach ($kmlCollection as $kml) {
            $this->elementService->create([
                'layer_id' => 1,
                'title' => $kml->name,
                'description' => $kml->name,
            ]);
        }
    }

    /**
     * KMZLayer now has alias 'pitayushchiye-punkty'
     */
    private function defineKmzLayer()
    {
        // Get layer based on repository
    }
}
