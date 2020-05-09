<?php


namespace App\src\Utilities\KMZParser\Entities;

use stdClass;

class KMZElement
{
    public $name;
    public $coordinates;

    public $type;

    /**
     * KMZElement constructor.
     * @param $name: string
     * @param $coordinates: string
     * @param $type: string
     */
    public function __construct(string $name, $coordinates, string $type)
    {
        $this->name = $name;
        $this->coordinates = $coordinates;
        $this->type = $type;
    }

    /**
     * Преобразовывает в элемент для хранения в БД
     * @param $layerId
     * @return stdClass
     */
    public function convertToLayerElement($layerId)
    {
        $layerObj = new stdClass();
        $layerObj->layer_id = $layerId;
        $layerObj->title = $this->name;
        $layerObj->description = $this->name;
        $layerObj->geometry = $this->parseGeometry();

        return $layerObj;
    }

    public function parseGeometry()
    {
        // TODO: Include throw Exception if offset is not working
        $normalizedCoords = explode(',', $this->coordinates);
        return 'POINT('.$normalizedCoords[0].' '.$normalizedCoords[1].')';
    }

}
