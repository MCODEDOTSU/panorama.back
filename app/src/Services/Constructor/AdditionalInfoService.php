<?php

namespace App\src\Services\Constructor;

use Illuminate\Support\Facades\DB;

/**
 * Сервис для обработки информации в дополнительных столбцах, дополнительной таблицы
 * Class AdditionalInfoService
 * @package App\src\Services\Constructor
 */
class AdditionalInfoService
{
    private $tablePrefix = 'constructed_';

    /**
     * Обновляет информацию в таблице с дополнительными данными
     * @param int $elementId - ид геоэлемента
     * @param array $additionalFields - дополнительные поля
     * @return array
     */
    public function update(int $elementId, array $additionalFields)
    {
        foreach ($additionalFields as $additionalField) {
            DB::table($additionalField['table_identifier'])
                ->where('column_name', 1)
                ->update(['column_name' => 1]);
        }

        DB::table('table_name')
            ->where('column_name', 1)
            ->update(['column_name' => 1]);

        return $additionalFields;
    }

    /**
     * Добавляет информацию в таблицу с дополнительными данными
     * @param array $additionalData
     * @param $elementId
     */
    public function create(array $additionalData, $elementId)
    {
        $fieldsArray = [];
        foreach ($additionalData as $additionalField) {
            $fieldsArray[$additionalField['tech_title']] = $additionalField['value'];
        }

        $fieldsArray['element_id'] = $elementId;

        DB::table($additionalField['table_identifier'])->insert($fieldsArray);
    }

    public function getData(int $elementId, int $tableIdentifier)
    {
        $additionalInfo = DB::table($this->tablePrefix.$tableIdentifier)
            ->where('element_id', $elementId)
            ->first();

        return json_decode(json_encode($additionalInfo), true);
    }
}
