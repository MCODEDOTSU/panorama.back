<?php

declare(strict_types=1);

namespace App\src\Services\Constructor;


use App\src\Repositories\Constructor\ConstructorRepository;
use App\src\Services\Constructor\Entities\FieldsResolver;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
    
    public function createTable(Request $request): string
    {
        Schema::create($this->tablePrefix . $request->table_title, function (Blueprint $table) use ($request) {
            $this->parseColumns($request, $table);
            $this->addGeoElementsAsForeignKey($table);
        });
        
        $this->constructorMetadataService->saveTableInfo($request->columns, $request->table_title);
        
        return $this->tablePrefix . $request->table_title;
    }
    
    public function updateTable(Request $request)
    {
        Schema::table($this->tablePrefix . $request->table_title, function (Blueprint $table) use ($request) {
            $this->checkChangesInColumns($request->columns, $request->table_title, $table);
        });

        return $this->tablePrefix . $request->table_title;
    }
    
    /**
     * Удалить таблицу
     * @param $request :
     * Название таблицы
     */
    public function dropTable(Request $request): void
    {
        Schema::dropIfExists($request->table_title);
    }
    
    /**
     * Конвертирует json массив в столбцы новой таблицы
     * @param $request
     * @param $table
     */
    private function parseColumns($request, Blueprint $table): void
    {
        $colArr = $request->columns;
        
        foreach ($colArr as $col) {
            $fieldType = $this->fieldsResolver->selectFieldType($col);
            
            $fieldType->constructField($table);
        }
    }
    
    private function parseSingleColumn(array $columnData, Blueprint $updatedTable, $tableNumber)
    {
        $fieldType = $this->fieldsResolver->selectFieldType($columnData);
        $fieldType->constructField($updatedTable);
        $this->constructorMetadataService->createColumn($columnData, $this->tablePrefix . $tableNumber);
    }
    
    /**
     * Добавить внещний ключ на таблицу geo_elements
     * TODO: Нужен ли только на geo_elements или на geo_layers - тоже???
     * @param $table - таблица с готовыми столбцами
     */
    private function addGeoElementsAsForeignKey($table)
    {
        $table->integer('element_id')->unsigned();
        $table->foreign('element_id')->references('id')->on('geo_elements');
    }
    
    
    public function getSpecificType(string $type)
    {
        return $type;
    }
    
    /**
     * Получить сводную информацию о столбцах
     * @param string $tableIdentifier
     * @return Collection
     */
    public function getTableInfo(string $tableIdentifier): Collection
    {
        return $this->constructorRepository->getTableInfo($this->tablePrefix . $tableIdentifier);
    }
    
    /**
     * Проверить - существует ли таблица
     * @param string $tableIdentifier
     * @return string
     */
    public function isTableExists(string $tableIdentifier): string
    {
        if (!Schema::hasTable($this->tablePrefix . $tableIdentifier)) {
            return 'false';
        }
        
        return 'true';
    }
    
    /**
     * Проверить изменения в колонках (для обновления структуры таблицы)
     * @param array $columns
     * @param $tableNumber
     * @param $updatedTable - Обновляемая таблица по Schema
     * @return mixed
     */
    private function checkChangesInColumns(array $columns, $tableNumber, Blueprint $updatedTable)
    {
        // Проверить изменения в составе таблицы
        foreach ($columns as $columnData) {
            if(isset($columnData['id'])) {
                $savedColumnInfo = $this->constructorRepository->getById($columnData['id']);
                $this->updateColumnInfo($columnData, $savedColumnInfo, $updatedTable);
            } else {
                $this->parseSingleColumn($columnData, $updatedTable, $tableNumber);
            }
        }
    }

    /**
     * Изменить структуру таблицы
     * @param $columnData
     * @param $savedColumnInfo
     * @param Blueprint $updatedTable
     */
    private function updateColumnInfo($columnData, $savedColumnInfo, Blueprint $updatedTable)
    {
        $fieldType = $this->fieldsResolver->selectFieldType($columnData);
        $fieldType->setNewTechTitle($columnData['tech_title']);
        $fieldType->setTechTitle($savedColumnInfo->tech_title);

        // Поле не подлежит переименованию, если старое и новое названия совпадают
        if($fieldType->getTechTitle() != $fieldType->getNewTechTitle()) {
            $fieldType->renameField($updatedTable);
        }
        $fieldType->changeFieldType($updatedTable);

        $this->constructorRepository->updateColumnInfo($savedColumnInfo, $columnData);
    }
}
