<?php

declare(strict_types=1);

namespace App\src\Services\Constructor;


use App\src\Services\Constructor\Entities\FieldsResolver;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
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
        });
    }

    /**
     * Удалить таблицу
     * @param $request:
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

            $typePr = $fieldType->getType();
            $table->$typePr(''.$fieldType->getTitle().'');
        }
    }

    public function getSpecificType(string $type)
    {
        return $type;
    }


}
