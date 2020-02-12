<?php

namespace App\src\Services\Constructor\Entities;


class DocField extends AbstractField implements FieldsChooseableInterface
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

    public function getFieldsToSaveInMetadataTable(array $columnData): array
    {
        $fieldsArray = parent::getFieldsToSaveInMetadataTable($columnData);
        $fieldsArray['enums'] = json_encode($columnData['enums']);

        return $fieldsArray;
    }
}
