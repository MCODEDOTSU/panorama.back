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
    
    private $constructorService;
    
    public function __construct(ConstructorService $constructorService)
    {
        $this->constructorService = $constructorService;
    }
    
    /**
     * Обновляет информацию в таблице с дополнительными данными
     * @param int $elementId - ид геоэлемента
     * @param array $additionalFields - дополнительные поля
     * @return array
     */
    public function update(int $elementId, array $additionalFields)
    {
        return $elementId;
        return $additionalFields;
       
        if($this->checkIfAdditionalDataAlreadyExists($elementId, $additionalField['table_identifier'])) {
            foreach ($additionalFields as $additionalField) {
                // update data
                DB::table('table_name')
                ->where('column_name', 1)
                ->update(['column_name' => 1]);
            }
        }



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
    
    /**
     * Получить данные о таблице и получить дополнительные данные к ней
     * @param int $elementId
     * @param int $tableIdentifier
     * @return \Illuminate\Support\Collection
     */
    public function getData(int $elementId, int $tableIdentifier)
    {
        $tableInfo = $this->constructorService->getTableInfo($tableIdentifier);
    
        $additionalInfo = DB::table($this->tablePrefix.$tableIdentifier)
            ->where('element_id', $elementId)
            ->first();
        
        $decodedAdditionalInfo = json_decode(json_encode($additionalInfo), true);
        
        foreach ($tableInfo as $infoItem) {
            $infoItem->value = $decodedAdditionalInfo[$infoItem->tech_title];
        }
        
        return $tableInfo;
    }
    
    /**
     * Проверить заполнены ли дополнительные данные
     * @param int $elementId
     * @param $tableIdentifier - идентификатор таблицы
     * @return bool
     */
    public function checkIfAdditionalDataAlreadyExists(int $elementId, $tableIdentifier): bool
    {
        $additionalInfo = DB::table($this->tablePrefix.$tableIdentifier)
            ->where('element_id', $elementId)
            ->first();
        
        if($additionalInfo) {
            return true;
        }
        
        return false;
    }
}
