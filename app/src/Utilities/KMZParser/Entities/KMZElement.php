<?php


namespace App\src\Utilities\KMZParser\Entities;


use App\src\Services\Geo\GeometryService\Linestring;
use App\src\Services\Geo\GeometryService\Point;

class KMZElement
{
    public $name;
    public $coordinates;

    /**
     * @var Point | Linestring
     */
    public $type;

    /**
     * KMZElement constructor.
     * @param $name
     * @param $coordinates
     * @param Linestring|Point $type
     */
    public function __construct($name, $coordinates, $type)
    {
        $this->name = $name;
        $this->coordinates = $coordinates;
        $this->type = $type;
    }

}
