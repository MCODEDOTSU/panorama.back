<?php

namespace App\src\Services\Constructor\Entities;


class LongTextField extends AbstractField implements FieldInterface
{
    public $type = 'text';
    
    public function setDefaultValue()
    {
        return 'Не указано';
    }
    
    public function getType(): string
    {
        return $this->type;
    }
}
