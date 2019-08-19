<?php

namespace App\src\Services\Constructor\Entities;


class ImageField extends AbstractField implements FieldInterface
{
    protected $type = 'string';
    
    public function setDefaultValue()
    {
        return null;
    }
    
    public function getType(): string
    {
        return $this->type;
    }
}
