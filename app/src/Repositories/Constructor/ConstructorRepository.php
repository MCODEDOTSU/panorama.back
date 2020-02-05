<?php

namespace App\src\Repositories\Constructor;

use App\src\Models\ConstructorMetadata;

class ConstructorRepository
{
    private $constructorMetadata;

    /**
     * ConstructorRepository constructor.
     * @param ConstructorMetadata $constructorMetadata
     */
    public function __construct(ConstructorMetadata $constructorMetadata)
    {
        $this->constructorMetadata = $constructorMetadata;
    }

    /**
     * Получить информацию о таблице и её полях
     * @param string $tableIdentifier
     * @return mixed
     */
    public function getToLayer(string $tableIdentifier)
    {
        return $this->constructorMetadata
            ->where('table_identifier', $tableIdentifier)
            ->get();
    }

    /**
     * Сохранить информацию о вновь созданной таблице в constructor_metadata
     * @param array $columnData
     * @return
     */
    public function saveTableInfo(array $columnData)
    {
        return $this->constructorMetadata->create($columnData);
    }
    
    /**
     * Получить метаданные об отдельном столбце
     * @param string $columnIdentifier - tech_title
     * @param string $tableIdentifier - table_identifier
     * @return
     */
    public function getColumnMetadataInfo(string $columnIdentifier, string $tableIdentifier): ConstructorMetadata
    {
        return $this->constructorMetadata
            ->where([
                'table_identifier' => $tableIdentifier,
                'tech_title' => $columnIdentifier
            ])
            ->first();
    }

    /**
     * Получить метаданные по ИД
     * @param int $id
     * @return ConstructorMetadata
     */
    public function getById(int $id): ConstructorMetadata
    {
        return $this->constructorMetadata->find($id);
    }

    /**
     * Обновить информацию о таблице
     * @param ConstructorMetadata $columnModel
     * @param $column
     * @return ConstructorMetadata
     */
    public function updateColumnInfo(ConstructorMetadata $columnModel, $column)
    {
        $columnModel->tech_title = $column['tech_title'];
        $columnModel->title = $column['title'];
        $columnModel->type = $column['type'];
        $columnModel->required = $column['required'];
        $columnModel->enums = json_encode($column['enums']);
        $columnModel->group = $column['group'];
        $columnModel->is_deleted = $column['is_deleted'];
        $columnModel->save();

        return $columnModel;
    }

    public function delete(ConstructorMetadata $metadataInfo)
    {
        $metadataInfo->delete();
    }
}
