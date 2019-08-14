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
     * @param $tableIdentifier - ИД слоя (или таблицы)
     * @return array
     */
    public function update(int $elementId, array $additionalFields, $tableIdentifier)
    {
        if($this->checkIfAdditionalDataAlreadyExists($elementId, $tableIdentifier)) {
            $fieldsArray = [];
    
            foreach ($additionalFields as $additionalField) {
                $fieldsArray[$additionalField['tech_title']] = $additionalField['value'];
            }
            
            DB::table($this->tablePrefix.$tableIdentifier)
                ->where('element_id', $elementId)
                ->update($fieldsArray);
        } else {
            // На случай, если был добавлен элемент без данного функционала
            $this->create($additionalFields, $elementId);
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
     * @return \Illuminate\Support\Collection|string
     */
    public function getData(int $elementId, int $tableIdentifier)
    {
        if($this->constructorService->isTableExists($tableIdentifier) == 'false') {
            return 'false';
        }
        
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
