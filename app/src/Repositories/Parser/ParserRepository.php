<?php

namespace App\src\Repositories\Parser;

use App\src\Services\Parser\Grids\SupportsGrid;
use Illuminate\Support\Facades\DB;

class ParserRepository
{
    private $parserGrid;

    /**
     * ParserRepository constructor.
     * TODO: Вмемсто SupportsGrid - будет механизм рехолвера Сетки (Grid) для выбора нужной
     * @param SupportsGrid $parserGrid
     */
    public function __construct(SupportsGrid $parserGrid)
    {
        $this->parserGrid = $parserGrid;
    }


    /**
     * Сохранить данные парсинга в таблицы
     * @param array $data
     */
    public function persist(array $data)
    {
        DB::table($this->parserGrid->getTableName())
            ->insert($data);
    }
}
