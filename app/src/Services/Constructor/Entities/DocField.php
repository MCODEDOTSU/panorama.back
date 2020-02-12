<?php

namespace App\src\Services\Constructor\Entities;


class DocField extends AbstractField implements FieldInterface
{
    public $type = 'text';

    public function setDefaultValue()
    {
        return null;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Присваивает значение и превращает в json поле
     * @param $value
     * @return mixed|void
     */
    public function assignValue($value)
    {
        return json_encode($value);
    }
}
