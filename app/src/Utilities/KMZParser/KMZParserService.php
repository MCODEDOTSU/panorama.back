<?php

namespace App\src\Utilities\KMZParser;

use App\src\Models\Element;
use App\src\Services\Gis\ElementService;
use App\src\Services\Gis\LayerService;
use App\src\Utilities\KMZParser\Entities\KMZElement;
use Illuminate\Support\Collection;
use stdClass;

class KMZParserService
{
    /** @var ElementService */
    private $elementService;

    /** @var LayerService */
    private $layerService;

    /**
     * KMZParserService constructor.
     * @param ElementService $elementService
     * @param LayerService $layerService
     */
    public function __construct(ElementService $elementService, LayerService $layerService)
    {
        $this->elementService = $elementService;
        $this->layerService = $layerService;
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
                isset($kmzElement->coordinates) ? $kmzCollection->push($kmzElement) : null;
            }
        }

        return $kmzCollection;

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

    /**
     * @param Collection $kmlCollection - Collection of KML parsed objects
     * @param int $layerId - layer to store kmls
     */
    public function storeKmls(Collection $kmlCollection, int $layerId) {

        /** @var KMZElement $kml */
        foreach ($kmlCollection as $kml) {

            /** @var Element $element */
            $elementToObject = $kml->convertToLayerElement($layerId);
            $this->resolveKml($elementToObject);
        }
    }

    /**
     * Strategy
     * 1. if there is kml with the same name => update it
     * 2. if there is no kml with the same name => create it
     * @param stdClass $elementToObject
     */
    private function resolveKml(stdClass $elementToObject)
    {
        $element = $this->elementService->getByName($elementToObject->title);

        if (!$element) {
            $element = $this->elementService->create($elementToObject);
        }

        $this->elementService->updateGeometry(
            $element->id,
            $elementToObject
        );
    }
}
