<?php

declare(strict_types=1);

namespace App\src\Services\Constructor;


use App\src\Services\Constructor\Entities\FieldsResolver;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConstructorService
{
    private $fieldsResolver;

    /**
     * ConstructorService constructor.
     * @param $fieldsResolver
     */
    public function __construct(FieldsResolver $fieldsResolver)
    {
        $this->fieldsResolver = $fieldsResolver;
    }


    public function createTable(Request $request): void
    {
        Schema::create($request->table_title, function (Blueprint $table) use ($request) {
            $this->parseColumns($request, $table);
            $this->addGeoElementsAsForeignKey($table);
        });
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
     * @param string $tableName
     * @return array
     */
    public function getTableInfo(string $tableName): array
    {
        $tableCols = Schema::getColumnListing($tableName);

        $tableColsSummary = array();

        foreach ($tableCols as $tableCol) {
            array_push($tableColsSummary, [
                'title' => $tableCol,
                'type' => DB::getSchemaBuilder()->getColumnType($tableName, $tableCol)
            ]);
        }

        return $tableColsSummary;
    }


}
