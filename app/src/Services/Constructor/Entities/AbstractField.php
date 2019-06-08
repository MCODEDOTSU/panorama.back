<?php

namespace App\src\Services\Constructor\Entities;


class AbstractField
{
    /**
     * Наименование поля
     * @var
     */
    public $title;

    /**
     * Тип поля
     * @var
     */
    public $type;

    /**
     * Длина - для строковых полей
     * @var
     */
    public $length;

    /**
     * Получить информацию по типу поля
     * @return array
     */
    public function getFieldInfo(): array
    {
        return [
            'title' => $this->title,
            'type' => $this->type,
            'length' => $this->length
        ];
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

}
