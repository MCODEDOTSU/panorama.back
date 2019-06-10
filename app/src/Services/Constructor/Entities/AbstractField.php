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
     * Техническое наименование
     * @var
     */
    public $techTitle;

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
     * Сформировать поле таблицы согласно различным параметрам
     * @param $table
     */
    public function constructField($table)
    {
        $typePr = $this->getType();

        $composedCol = $table->$typePr('' . $this->getTechTitle() . '');
        $this->checkIfFieldIsNullable($composedCol);

    }

    /**
     * Выяснить, является ли поле обязательным или нет
     * @param $composedCol - сформирован тип и название столбца
     * @return mixed
     */
    public function checkIfFieldIsNullable($composedCol)
    {
        if ($this->required) {
            return $composedCol->nullable();
        }

        return $composedCol;
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

    /**
     * @return mixed
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param mixed $required
     */
    public function setRequired($required): void
    {
        $this->required = $required;
    }

    /**
     * @return mixed
     */
    public function getTechTitle()
    {
        return $this->techTitle;
    }

    /**
     * @param mixed $techTitle
     */
    public function setTechTitle($techTitle): void
    {
        $this->techTitle = $techTitle;
    }

}
