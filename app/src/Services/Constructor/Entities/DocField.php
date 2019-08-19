<?php

namespace App\src\Services\Constructor\Entities;


class DocField extends AbstractField implements FieldInterface
{
    private $type = 'text';
    
    public function setDefaultValue()
    {
        return null;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
}
