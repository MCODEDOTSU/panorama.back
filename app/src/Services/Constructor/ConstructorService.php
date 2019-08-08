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

    /**
     * ConstructorService constructor.
     * @param FieldsResolver $fieldsResolver
     * @param ConstructorRepository $constructorRepository
     */
    public function __construct(FieldsResolver $fieldsResolver, ConstructorRepository $constructorRepository)
    {
        $this->fieldsResolver = $fieldsResolver;
        $this->constructorRepository = $constructorRepository;
    }

    public function createTable(Request $request): string
    {
        Schema::create($this->tablePrefix . $request->table_title, function (Blueprint $table) use ($request) {
            $this->parseColumns($request, $table);
            $this->addGeoElementsAsForeignKey($table);
        });

        $this->saveTableInfo($request->columns, $request->table_title);

        return $this->tablePrefix . $request->table_title;
    }

    public function updateTable(Request $request)
    {
//        return $this->checkChangesInColumns($request->columns, $request->table_title);

        Schema::table($this->tablePrefix . $request->table_title, function (Blueprint $table) use ($request) {
            $this->checkChangesInColumns($request->columns, $request->table_title, $table);
        });

        $this->saveTableInfo($request->columns, $request->table_title);

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
     * Сохранить информацию о вновь созданной таблице в БД
     * @param array $columns
     * @param string $tableTitle
     */
    private function saveTableInfo(array $columns, string $tableTitle)
    {
        foreach ($columns as $col) {
            $this->constructorRepository->saveTableInfo([
                'table_identifier' => $this->tablePrefix.$tableTitle,
                'title' => $col['title'],
                'tech_title' => $col['tech_title'],
                'required' => $col['required'],
                'type' => $col['type'],
            ]);
        }
    }


    /**
     * Конвертирует json массив в столбцы новой таблицы
     * @param $request
     * @param $table
     */
    private function parseColumns($request, $table): void
    {
        $colArr = $request->columns;

        foreach ($colArr as $col) {
            $fieldType = $this->fieldsResolver->selectFieldType($col);

            $fieldType->constructField($table);
        }
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
        $tableTitle = $this->tablePrefix . $tableNumber;
        $tableInfo = $this->constructorRepository->getTableInfo($tableTitle);

        // Проверить изменения в составе таблицы
        foreach ($columns as $column) {
            return $this->checkChangesInColumn($tableInfo, $column, $updatedTable);
        }
    }

    /**
     * Проверить изменения в столбце
     * @param array $tableInfo
     * @param $column
     * @param Blueprint $updatedTable - обновляемая таблица
     * @return mixed
     */
    private function checkChangesInColumn($tableInfo, $column, Blueprint $updatedTable)
    {
        foreach ($tableInfo as $tableColumn) {
            if ($tableColumn->name == $column['tech_title']) {
                $updatedTable->unsignedInteger('address')->nullable()->change();
            }
        }
    }
}
