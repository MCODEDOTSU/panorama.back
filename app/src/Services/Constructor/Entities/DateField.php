<?php

namespace App\src\Services\Constructor\Entities;


class DateField extends AbstractField implements FieldInterface
{
    // TODO: При присвоении полю private или protected - выдается фатальная ошибка. Нужно проверить
    public $type = 'date';
    
    public function setDefaultValue()
    {
        return '1970-01-01';
    }
    
    public function getType(): string
    {
        return $this->type;
    }
}
