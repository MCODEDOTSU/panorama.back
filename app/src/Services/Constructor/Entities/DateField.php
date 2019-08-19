<?php

namespace App\src\Services\Constructor\Entities;


class DateField extends AbstractField implements FieldInterface
{
    protected $type = 'date';
    
    public function setDefaultValue()
    {
        return '1970-01-01';
    }
    
    public function getType(): string
    {
        return $this->type;
    }
}
