<?php

namespace App\src\Services\Constructor\Entities;


class OneFromManyField extends AbstractField implements FieldInterface
{
    // TODO: json_b - является встроенным типом postgres - будет ли он отрабатывать???
    public $type = 'json_b';
    
    public function setDefaultValue()
    {
        return null;
    }
    
    /**
     * @return string
     * Тип соответствует типу в объектной модели Schema
     */
    public function getType(): string
    {
        return $this->type;
    }
}
