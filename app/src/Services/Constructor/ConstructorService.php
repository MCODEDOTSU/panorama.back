<?php

declare(strict_types=1);

namespace App\src\Services\Constructor;

use App\src\Repositories\Constructor\ConstructorRepository;
use App\src\Services\Constructor\Entities\FieldsResolver;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConstructorService
{
    /**
     * Префикс используется при создании кастомных таблиц.
     * constructed_{id слоя}
     * @var string
     */
    private $tablePrefix = 'constructed_';

    private $fieldsResolver;
    private $constructorRepository;
    private $constructorMetadataService;

    private $fieldType;

    /**
     * ConstructorService constructor.
     * @param FieldsResolver $fieldsResolver
     * @param ConstructorRepository $constructorRepository
     * @param ConstructorMetadataService $constructorMetadataService
     */
    public function __construct(FieldsResolver $fieldsResolver, ConstructorRepository $constructorRepository, ConstructorMetadataService $constructorMetadataService)
    {
        $this->fieldsResolver = $fieldsResolver;
        $this->constructorRepository = $constructorRepository;
        $this->constructorMetadataService = $constructorMetadataService;
    }

    /**
     * Проверить - существует ли таблица
     * @param $layerId
     * @return array
     */
    public function getToLayer(int $layerId): array
    {
        if (!Schema::hasTable($this->tablePrefix . $layerId)) {
            return [];
        }

        $result = [];
        $tableColumns = $this->constructorRepository->getToLayer($this->tablePrefix . $layerId);
        $grouppedColumns = $tableColumns->groupBy('group');
        foreach ($grouppedColumns as $key => $tableColumn) {
            array_push($result, [
                'group' => $key,
                'columns' => $tableColumn
            ]);
        }

        return $result;
    }

    /***
     * Создать новую таблицу с данными
     * @param int $layerId
     * @param array $columns
     * @return string
     */
    public function create(int $layerId, array $columns): string
    {
        if (!Schema::hasTable($this->tablePrefix . $layerId)) {
            Schema::create($this->tablePrefix . $layerId, function (Blueprint $table) use ($columns) {
                $this->parseColumns($columns, $table);
                $this->addGeoElementsAsForeignKey($table);
            });
            // Сохранить данные о столюцах таблицы в ConstructorMetadata
            $this->constructorMetadataService->saveTableInfo($columns, $layerId);
            return $this->tablePrefix . $layerId;
        } else {
            return $this->update($layerId, $columns);
        }
    }

    /***
     * Обновить таблицу с данными
     * @param int $layerId
     * @param array $columns
     * @return string
     */
    public function update(int $layerId, array $columns): string
    {
        Schema::table($this->tablePrefix . $layerId, function (Blueprint $table) use ($layerId, $columns) {
            $this->checkChangesInColumns($columns, $layerId, $table);
        });
        return $this->tablePrefix . $layerId;
    }

    /**
     * Конвертирует json массив в столбцы новой таблицы
     * @param $columns
     * @param Blueprint $table
     */
    private function parseColumns($columns, Blueprint $table): void
    {
        foreach ($columns as $column) {
            $fieldType = $this->fieldsResolver->selectFieldType($column);
            $fieldType->constructField($table);
        }
    }

    /**
     * Добавить внещний ключ на таблицу geo_elements
     * @param $table - таблица с готовыми столбцами
     */
    private function addGeoElementsAsForeignKey($table)
    {
        $table->integer('element_id')->unsigned();
        $table->foreign('element_id')->references('id')->on('geo_elements');
    }

    /**
     * Проверить изменения в колонках (для обновления структуры таблицы)
     * @param array $columns
     * @param int $layerId
     * @param Blueprint $table
     * @return mixed
     */
    private function checkChangesInColumns(array $columns, int $layerId, Blueprint $table)
    {
        // Проверить изменения в составе таблицы
        foreach ($columns as $column) {
            if (isset($column['id'])) {
                if ($column['is_deleted'] && !$this->hasColumnData($layerId, $column)) {
                    $this->dropColumn($layerId, $column);
                } else {
                    $metadata = $this->constructorRepository->getById($column['id']);
                    $this->updateColumnInfo($column, $metadata, $table);
                }
            } else {
                // Если добавляются новые столбцы с данными - добавить новые
                $this->parseSingleColumn($column, $layerId, $table);
            }
        }
    }

    /***
     * Добавляем новые поля в таблицу
     * @param array $column
     * @param Blueprint $updatedTable
     * @param $layerId
     */
    private function parseSingleColumn(array $column, $layerId, Blueprint $table)
    {
        $fieldType = $this->fieldsResolver->selectFieldType($column);
        $fieldType->constructField($table);
        $this->constructorMetadataService->createColumn($column, $this->tablePrefix . $layerId);
    }

    /**
     * Изменить структуру таблицы
     * @param $column
     * @param $metadata
     * @param Blueprint $table
     */
    private function updateColumnInfo($column, $metadata, Blueprint $table)
    {
        $fieldType = $this->fieldsResolver->selectFieldType($column);
        $fieldType->setNewTechTitle($column['tech_title']);
        $fieldType->setTechTitle($metadata->tech_title);

        // Поле не подлежит переименованию, если старое и новое названия совпадают
        if ($fieldType->getTechTitle() != $fieldType->getNewTechTitle()) {
            $fieldType->renameField($table);
        }
        $fieldType->changeFieldType($table);

        $this->constructorRepository->updateColumnInfo($metadata, $column);
    }

    /**
     * Проверить, есть ли данные перед удалением
     * @param int $layerId
     * @param array $column
     * @return bool
     */
    public function hasColumnData(int $layerId, array $column): bool
    {
        if (!Schema::hasColumn($this->tablePrefix . $layerId, $column['tech_title'])) {
            return false;
        }
        $count = DB::table($this->tablePrefix . $layerId)
            ->whereNotNull($column['tech_title'])
            ->count();
        return $count == 0 ? false : true;
    }

    /**
     * Удалить столбец
     * @param int $layerId
     * @param array $column
     */
    public function dropColumn(int $layerId, array $column): void
    {
        Schema::table($this->tablePrefix . $layerId, function (Blueprint $table) use ($column) {
            $table->dropColumn($column['tech_title']);
        });
        $this->constructorMetadataService->deleteColumnMetadata($column['tech_title'], $this->tablePrefix . $layerId);
    }

    public function getSpecificType(string $type)
    {
        return $type;
    }
}
