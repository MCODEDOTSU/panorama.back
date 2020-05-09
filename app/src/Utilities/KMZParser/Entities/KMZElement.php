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
     * @param $name: string
     * @param $coordinates: array
     * @param $type: string
     */
    public function __construct(string $name, array $coordinates, string $type)
    {
        $this->name = $name;
        $this->coordinates = $coordinates;
        $this->type = $type;
    }

}
