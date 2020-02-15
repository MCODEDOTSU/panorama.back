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
     * @inheritDoc
     */
    public function assignValue($value)
    {
        return json_encode($value);
    }

    /**
     * @inheritDoc
     */
    public function extractValue($value)
    {
        return json_decode($value);
    }

    public function getFieldsToSaveInMetadataTable(array $columnData): array
    {
        $fieldsArray = parent::getFieldsToSaveInMetadataTable($columnData);
        $fieldsArray['enums'] = json_encode($columnData['enums']);

        return $fieldsArray;
    }
}
