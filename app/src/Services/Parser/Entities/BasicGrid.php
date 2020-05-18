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

    public function getColumnByTitle($cellTitle) {
        $cellNameComparator = function ($title) {
            return function ($cell) use ($title) { return $cell->name == $title; };
        };

        $titleColFilter = array_filter($this->cells, $cellNameComparator($cellTitle));
        return array_pop($titleColFilter)->column;
    }
}
