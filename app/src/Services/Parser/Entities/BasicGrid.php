<?php

namespace App\src\Services\Parser\Entities;

class BasicGrid
{
    /**
     * @var Cell[]
     */
    public $cells;

    /**
     * BasicGrid constructor.
     * @param Cell[] $cells
     */
    public function __construct(array $cells)
    {
        $this->cells = $cells;
    }
}
