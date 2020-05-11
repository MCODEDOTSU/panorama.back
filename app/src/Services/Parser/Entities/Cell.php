<?php

namespace App\src\Services\Parser\Entities;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Cell
{
    public $name;
    public $column;
    public $isComplex;

    /**
     * Cell constructor.
     * @param $name => represents name in DB
     * @param $column => represents Excel column
     * @param $isComplex => if complex = consists of several cells
     */
    public function __construct($name, $column, $isComplex)
    {
        $this->name = $name;
        $this->column = $column;
        $this->isComplex = $isComplex;
    }
}
