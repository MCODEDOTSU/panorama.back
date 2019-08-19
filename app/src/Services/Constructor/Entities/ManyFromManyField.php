<?php

namespace App\src\Services\Constructor\Entities;


class ManyFromManyField extends AbstractField implements FieldsChooseableInterface
{
    public $type = 'jsonb';
    
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

    /**
     * Получить таблицы для метода внесения данных в constructor_metadata.
     * Для OneFromMany - добавляются данные enums
     * @param array $columnData
     * @return array
     */
    public function getFieldsToSaveInMetadataTable(array $columnData): array
    {
        $fieldsArray = parent::getFieldsToSaveInMetadataTable($columnData);
        $fieldsArray['enums'] = json_encode($columnData['enums']);

        return $fieldsArray;
    }
}
