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
                $this->updateColumnInfo($columnModel, $column);
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
     * Обновить информацию о таблице
     * @param ConstructorMetadata $columnModel
     * @param $column
     * @return ConstructorMetadata
     */
    private function updateColumnInfo(ConstructorMetadata $columnModel, $column): ConstructorMetadata
    {
        $columnModel->tech_title = $column['new_tech_title'];
        $columnModel->title = $column['title'];
        $columnModel->type = $column['type'];
        $columnModel->save();
        
        return $columnModel;
    }
    
    /**
     * Добавить информацию о поле
     * @param array $columnData
     * @param string $tableName
     */
    private function createColumn(array $columnData, string $tableName)
    {
        $this->constructorRepository->saveTableInfo([
            'table_identifier' => $tableName,
            'title' => $columnData['title'],
            'tech_title' => $columnData['tech_title'],
            'required' => $columnData['required'],
            'type' => $columnData['type'],
        ]);
    }
}
