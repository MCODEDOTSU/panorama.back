<?php

declare(strict_types=1);

namespace App\src\Services\Constructor;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ConstructorService
{
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
        $colArr = json_decode($request->columns);

        foreach ($colArr as $col) {
            $typePr = $col->type;
            $table->$typePr(''.$col->title.'');
        }
    }
}
