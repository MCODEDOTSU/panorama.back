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
     * Может ли быть nullable
     * @var
     */
    public $required;

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
     * Выяснить, является ли поле обязательным или нет
     */
    public function checkIfFieldIsNullable()
    {
        // TODO: выясняем
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

}
