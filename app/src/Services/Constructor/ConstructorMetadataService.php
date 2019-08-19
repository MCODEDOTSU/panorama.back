<?php


namespace App\src\Services\Constructor;


use App\src\Models\ConstructorMetadata;
use App\src\Repositories\Constructor\ConstructorRepository;

class ConstructorMetadataService
{
    /**
     * Префикс используется при создании кастомных таблиц.
     * constructed_{id слоя}
     * @var string
     */
    private $tablePrefix = 'constructed_';
    
    private $constructorRepository;
    
    /**
     * ConstructorMetadataService constructor.
     * @param ConstructorRepository $constructorRepository
     */
    public function __construct(ConstructorRepository $constructorRepository)
    {
        $this->constructorRepository = $constructorRepository;
    }
    
    /**
     * Если поле существует, то просто обновить, если нет - то создать по новой
     * @param array $columns - информация о столбцах
     * @param string $tableIdentifier - идентификатор таблицы
     * @return void
     */
    public function updateMetadataInformation(array $columns, string $tableIdentifier)
    {
        foreach ($columns as $column) {
            if (isset($column['tech_title'])) {
                $columnModel = $this->constructorRepository->getColumnMetadataInfo($column['tech_title'], $this->tablePrefix . $tableIdentifier);
                $column['tech_title'] = $column['new_tech_title'];
                $this->constructorRepository->updateColumnInfo($columnModel, $column);
            } else {
                $column['tech_title'] = $column['new_tech_title'];
                $this->createColumn($column, $this->tablePrefix . $tableIdentifier);
            }
        }
    }
    
    /**
     * Сохранить информацию о вновь созданной таблице в БД
     * @param array $columns
     * @param string $tableTitle
     */
    public function saveTableInfo($columns, $tableTitle)
    {
        foreach ($columns as $col) {
            $this->createColumn($col, $this->tablePrefix . $tableTitle);
        }
    }
    
    /**
     * Добавить информацию о поле
     * @param array $columnData
     * @param string $tableName
     */
    public function createColumn(array $columnData, string $tableName)
    {
        $this->constructorRepository->saveTableInfo([
            'table_identifier' => $tableName,
            'title' => $columnData['title'],
            'tech_title' => $columnData['tech_title'],
            'required' => $columnData['required'],
            'type' => $columnData['type'],
        ]);
    }

    /**
     * Удалить информацию о столбце из метаданных
     * @param $columnTechTitle
     * @param $tableName
     */
    public function deleteColumnMetadata(string $columnTechTitle, string $tableName): void
    {
        $metadataInfo = $this->constructorRepository->getColumnMetadataInfo($columnTechTitle, $tableName);
        $this->constructorRepository->delete($metadataInfo);
    }
}