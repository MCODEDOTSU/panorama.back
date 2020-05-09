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
     * @param $coordinates: array
     * @param $type: string
     */
    public function __construct(string $name, string $coordinates, string $type)
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

        return $layerObj;
    }

}
