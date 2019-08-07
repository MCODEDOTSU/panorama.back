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
    /**
     * Обновляет информацию в таблице с дополнительными данными
     * @param int $elementId - ид геоэлемента
     * @param array $additionalFields - дополнительные поля
     * @return array
     */
    public function update(int $elementId, array $additionalFields)
    {
        DB::table('table_name')
            ->where('column_name', 1)
            ->update(['column_name' => 1]);

        return $additionalFields;
    }

    /**
     * Добавляет информацию в таблицу с дополнительными данными
     * @param array $additionalData
     */
    public function create(array $additionalData)
    {
        DB::table('table_name')
            ->where('column_name', 1)
            ->create();
    }
}
