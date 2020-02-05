<?php

namespace App\src\Services\Constructor\Entities;


use Illuminate\Database\Schema\Blueprint;

class AbstractField
{
    /**
     * Наименование поля
     * @var string
     */
    public $title;

    /**
     * Техническое наименование
     * @var string
     */
    public $techTitle;

    /**
     * Новое техническое наименование
     * @var string
     */
    public $newTechTitle;

    /**
     * Тип поля
     * @var string
     */
    public $type;

    /**
     * Длина - для строковых полей
     * @var int
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
     * Добавить тип поля
     * Проверить, является ли поле nullable
     * @param $table
     */
    public function constructField(Blueprint $table)
    {
        $typePr = $this->getType();

        $composedCol = $table->$typePr('' . $this->getTechTitle() . '');
        $this->checkIfFieldIsNullable($composedCol);
        $composedCol->default($this->setDefaultValue());
    }

    /**
     * Изменить колонку в таблице
     * @param Blueprint $table
     */
    public function renameField(Blueprint $table)
    {
        $table->renameColumn($this->getTechTitle(), $this->getNewTechTitle());
    }
    
    /**
     * Изменить тип поля
     * Проверить, является ли поле nullable
     * @param Blueprint $table
     */
    public function changeFieldType(Blueprint $table)
    {
        $typePr = $this->getType();
        $composedCol = $table->$typePr('' . $this->getTechTitle() . '');
        $this->checkIfFieldIsNullable($composedCol);
        $composedCol->change();
    }

    /**
     * Выяснить, является ли поле обязательным или нет
     * @param $composedCol - сформирован тип и название столбца
     * @return mixed
     */
    public function checkIfFieldIsNullable($composedCol)
    {
        if (!$this->required) {
            return $composedCol->nullable();
        }

        return $composedCol;
    }

    public function getFieldsToSaveInMetadataTable(array $columnData): array
    {
        return [
            'title' => $columnData['title'],
            'tech_title' => $columnData['tech_title'],
            'required' => $columnData['required'],
            'type' => $columnData['type'],
            'group' => $columnData['group']
        ];
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

    /**
     * @return string
     */
    public function getNewTechTitle(): string
    {
        return $this->newTechTitle;
    }

    /**
     * @param string $newTechTitle
     */
    public function setNewTechTitle(string $newTechTitle): void
    {
        $this->newTechTitle = $newTechTitle;
    }
}
