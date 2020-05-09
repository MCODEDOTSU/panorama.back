<?php

namespace App\src\Utilities\KMZParser;

use App\src\Models\Layer;
use App\src\Services\Gis\ElementService;
use App\src\Services\Gis\LayerService;
use App\src\Utilities\KMZParser\Entities\KMZElement;
use Illuminate\Support\Collection;

class KMZParserService
{
    /** @var ElementService */
    private $elementService;

    /** @var LayerService */
    private $layerService;

    /** @var string */
    private const KMZ_LAYER_ALIAS = 'pitayushchiye-punkty';

    /** @var Layer */
    private $kmzLayer;

    /**
     * KMZParserService constructor.
     * @param ElementService $elementService
     * @param LayerService $layerService
     */
    public function __construct(ElementService $elementService, LayerService $layerService)
    {
        $this->elementService = $elementService;
        $this->layerService = $layerService;

        $this->kmzLayer = $this->defineKmzLayer();
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

        $coordinates = '';

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
            $this->elementService->create(
                $kml->convertToLayerElement($this->kmzLayer->id)
            );
        }
    }

    /**
     * KMZLayer now has alias 'pitayushchiye-punkty'
     */
    private function defineKmzLayer()
    {
        return $this->layerService->getByAlias(self::KMZ_LAYER_ALIAS);
    }
}
