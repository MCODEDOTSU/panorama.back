<?php

namespace App\src\Services\Constructor\Entities;


use phpDocumentor\Reflection\Types\Integer;

class LinkField extends AbstractField implements FieldInterface
{
    public $type = 'integer';
    
    public function setDefaultValue()
    {
        return null;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
}
