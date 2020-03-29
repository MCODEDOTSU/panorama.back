<?php

namespace App\src\Services\Parser\Grids;

class ExampleParserGrid
{
    private $grid = [
        'pp_number' => 'B2',
        'district' => 'E2',
        'street' => 'F2',
        'house' => 'G2',
        'cascade' => 'H2',
        'feeding_point_type' => 'I2',
        'type' => 'J2'
    ];

    public function getGrid() {
        return $this->grid;
    }
}
