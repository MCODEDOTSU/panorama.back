<?php

namespace App\src\Services\Constructor\Entities;


interface FieldsChooseableInterface extends FieldInterface
{
    /**
     * Для OneFromMany, ManyFromMany - добавляются данные enums
     * @param array $columnData
     * @return array
     */
    public function getFieldsToSaveInMetadataTable(array $columnData): array;
}
