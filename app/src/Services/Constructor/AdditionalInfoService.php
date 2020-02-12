<?php

namespace App\src\Services\Constructor;

use App\src\Services\Constructor\Entities\FieldsResolver;
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
    private $fieldsResolver;

    public function __construct(ConstructorService $constructorService, FieldsResolver $fieldsResolver)
    {
        $this->constructorService = $constructorService;
        $this->fieldsResolver = $fieldsResolver;
    }

    /**
     * Обновляет информацию в таблице с дополнительными данными
     * @param int $elementId - ид геоэлемента
     * @param array $additionalData
     * @param $layerId
     * @return array
     */
    public function update(int $elementId, array $additionalData, $layerId)
    {
        if ($this->checkIfAdditionalDataAlreadyExists($elementId, $layerId)) {
            $fieldsArray = [];

            foreach ($additionalData as $additionalField) {
                $fieldByType = $this->fieldsResolver->selectFieldType($additionalField);
                $fieldsArray[$additionalField['tech_title']] = $fieldByType->assignValue($additionalField['value']);
            }

            DB::table($this->tablePrefix . $layerId)
                ->where('element_id', $elementId)
                ->update($fieldsArray);

        } else {
            // На случай, если был добавлен элемент без данного функционала
            $this->create($elementId, $additionalData);
        }

        return $additionalData;
    }

    /**
     * Добавляет информацию в таблицу с дополнительными данными
     * @param array $additionalData
     * @param $elementId
     */
    public function create(int $elementId, array $additionalData)
    {
        $fieldsArray = [];
        foreach ($additionalData as $additionalField) {
            $fieldByType = $this->fieldsResolver->selectFieldType($additionalField);
            $fieldsArray[$additionalField['tech_title']] = $fieldByType->assignValue($additionalField['value']);
        }

        $fieldsArray['element_id'] = $elementId;

        DB::table($additionalField['table_identifier'])->insert($fieldsArray);
    }

    /**
     * Получить данные о таблице и получить дополнительные данные к ней
     * @param int $layerId
     * @param int $elementId
     * @return array|string
     */
    public function getData(int $layerId, int $elementId): array
    {
        $tableInfoByGroups = $this->constructorService->getToLayer($layerId);
        if(count($tableInfoByGroups) == 0) {
            return [];
        }

        $additionalInfo = DB::table($this->tablePrefix . $layerId)
            ->where('element_id', $elementId)
            ->first();

        $decodedAdditionalInfo = (array)$additionalInfo;

        return $this->distributeAdditionalInfoByGroups($tableInfoByGroups, $decodedAdditionalInfo);
    }

    private function distributeAdditionalInfoByGroups($tableInfoByGroups, $decodedAdditionalInfo)
    {
        foreach ($tableInfoByGroups as $infoByGroups) {
            foreach ($infoByGroups['columns'] as $infoItem) {
                if (!isset($decodedAdditionalInfo[$infoItem->tech_title])) {
                    $infoItem->value = null;
                } else {
                    $infoItem->value = $decodedAdditionalInfo[$infoItem->tech_title];
                    // Если в значении - json данные - превратить их в простые
                    $infoItem->value = json_decode($infoItem->value);
                }
            }
        }

        return $tableInfoByGroups;
    }

    /**
     * Проверить заполнены ли дополнительные данные
     * @param int $elementId
     * @param $tableIdentifier - идентификатор таблицы
     * @return bool
     */
    public function checkIfAdditionalDataAlreadyExists(int $elementId, $tableIdentifier): bool
    {
        $additionalInfo = DB::table($this->tablePrefix . $tableIdentifier)
            ->where('element_id', $elementId)
            ->first();

        if ($additionalInfo) {
            return true;
        }

        return false;
    }

    /**
     * @param string $tableIdentifier - name of dynamic table
     * @param string $columnName - column name
     * @param int $elementId - id of element for where clause
     */
    public function cleanDocField(string $tableIdentifier, string $columnName, int $elementId)
    {
        DB::table($tableIdentifier)
            ->where('element_id', $elementId)
            ->update([
                $columnName => null
            ]);
    }
}
