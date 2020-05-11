<?php

namespace App\src\Repositories\Parser;

use App\src\Services\Parser\Grids\SupportsGrid;
use Illuminate\Support\Facades\DB;

class ParserRepository
{
    /**
     * Сохранить данные парсинга в таблицы
     * @param array $data
     * @param string $tableName
     */
    public function persist(array $data, string $tableName)
    {
        DB::table($tableName)
            ->insert($data);
    }
}
