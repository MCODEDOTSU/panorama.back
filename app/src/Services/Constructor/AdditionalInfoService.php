<?php

namespace App\src\Services\Constructor;

use App\Exceptions\CustomException;
use App\src\Repositories\Constructor\AdditionalInfoRepository;
use App\src\Services\Constructor\Entities\FieldsResolver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\src\Services\Constructor\ConstructorMetadataService;
use Illuminate\Support\Facades\Log;

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
    private $constructorMetadataService;
    private $additionalInfoRepository;

    public function __construct(
        ConstructorService $constructorService,
        FieldsResolver $fieldsResolver,
        ConstructorMetadataService $constructorMetadataService,
        AdditionalInfoRepository $additionalInfoRepository)
    {
        $this->constructorService = $constructorService;
        $this->fieldsResolver = $fieldsResolver;
        $this->constructorMetadataService = $constructorMetadataService;
        $this->additionalInfoRepository = $additionalInfoRepository;
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
                if ($additionalField['type'] == 'doc_field' && !empty($additionalField['value'])) {
                    $additionalField['value'] = $this->getDocField($additionalField['value']);
                }
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
     * Удалить дополнительные поля Элемента
     * @param int $elementId
     * @param int $layerId
     */
    public function delete(int $elementId, int $layerId)
    {
        if (Schema::hasTable($this->tablePrefix . $layerId)) {
            DB::table($this->tablePrefix . $layerId)
                ->where('element_id', $elementId)
                ->delete();
        }
    }

    /**
     * Удалить дополнительные поля Элементов
     * @param $elements
     * @param int $layerId
     */
    public function deleteSome($elements, int $layerId)
    {
        if (Schema::hasTable($this->tablePrefix . $layerId)) {
            DB::table($this->tablePrefix . $layerId)
                ->whereIn('element_id', $elements)
                ->delete();
        }
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
        if (count($tableInfoByGroups) == 0) {
            return [];
        }

        $additionalInfo = $this->additionalInfoRepository->getAdditionalInfo(
            $this->tablePrefix . $layerId, $elementId);

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

                    $fieldByType = $this->fieldsResolver->selectFieldBasedOnlyOnType($infoItem->type);
                    $infoItem->value = $fieldByType->extractValue($decodedAdditionalInfo[$infoItem->tech_title]);
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
        $additionalInfo = $this->additionalInfoRepository->getAdditionalInfo(
            $this->tablePrefix . $tableIdentifier, $elementId);

        if ($additionalInfo) {
            return true;
        }

        return false;
    }

    /**
     * @param array $files
     * @return mixed
     */
    public function getDocField($files = [])
    {
        $result = [];
        foreach ($files as $file) {
            if ($file['isDeleted'] == true) {
                Storage::delete("public{$file['path']}");
            } else {
                $result[] = $file;
            }
        }
        return $result;
    }

    /**
     * Загрузить
     * @param $data
     * @return mixed
     * @throws CustomException
     */
    public function uploadFiles($data)
    {

        $constructorMetadata = $this->constructorMetadataService->getById($data->metadata_id);
        $maxCount = (int)$constructorMetadata->options->quantity;
        $currentCount = (int)$data->current_count;

        if ($constructorMetadata->type != 'doc_field') {
            throw new CustomException('Something Went Wrong.');
        }

        $errors = [];
        $result = [];

        foreach ($data['files'] as $file) {

            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if ($maxCount != 0 && (count($result) + $currentCount) >= $maxCount) {
                $errors[] = [
                    'title' => "$originalName",
                    'error' => "превышено максимально-допустимое число файлов"
                ];
                continue;
            }

            if (!in_array($extension, $constructorMetadata->enums)) {
                $errors[] = [
                    'title' => "$originalName",
                    'error' => "расширение .$extension не является допустимым"
                ];
                continue;
            }

            $file = $file->store('public/documents');
            // $filename = str_replace('/storage', '', Storage::url($file));
            $filename = url('/') . Storage::url($file);

            $size = round(Storage::size($file) / 1000, 2);
            $size = $size >= 1000 ? round($size / 1000, 2) . 'MB' : $size . 'KB';

            $result[] = [
                'isDeleted' => false,
                'title' => "$originalName ({$size})",
                'path' => $filename,
                'extension' => $extension
            ];
        }

        return ['result' => $result, 'errors' => $errors];
    }
}
