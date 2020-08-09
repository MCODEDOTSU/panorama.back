<?php


namespace App\src\Services\Constructor\Entities;


class DirectoryField extends AbstractField implements FieldInterface
{
    public $type = 'string';

    public function setDefaultValue()
    {
        return 'Не указано';
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
