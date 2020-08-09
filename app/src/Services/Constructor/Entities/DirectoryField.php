<?php


namespace App\src\Services\Constructor\Entities;


class DirectoryField extends AbstractField implements FieldInterface
{
    public $type = 'integer';

    public function setDefaultValue()
    {
        return 0;
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
