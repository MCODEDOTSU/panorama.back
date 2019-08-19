<?php

namespace App\src\Services\Constructor\Entities;


class ManyFromManyField extends AbstractField implements FieldInterface
{
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
