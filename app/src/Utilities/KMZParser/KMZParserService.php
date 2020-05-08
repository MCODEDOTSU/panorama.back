<?php


namespace App\src\Utilities\KMZParser;


use App\src\Utilities\KMZParser\Entities\KMZElement;
use Illuminate\Support\Collection;

class KMZParserService
{
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

        dd($kmzCollection);
    }

    private function parseSingleElement(array $childElement): KMZElement
    {
        $name = $childElement['name'];

        $coordinates = null;
        $elementType = null;

        $issetPoint = isset($childElement['Point']);
        $issetLineString = isset($childElement['LineString']);

        if ($issetPoint) {
            $point = (array)$childElement['Point'];
            $coordinates = $point['coordinates'];
            $elementType = 'POINT';
        }

        if ($issetLineString) {
            $point = (array)$childElement['LineString'];
            $coordinates = $point['coordinates'];
            $elementType = 'LINESTRING';
        }

        return new KMZElement($name, $coordinates, $elementType);
    }
}
