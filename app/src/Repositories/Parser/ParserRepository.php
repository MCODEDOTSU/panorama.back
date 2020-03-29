<?php

namespace App\src\Repositories\Parser;

use App\src\Services\Parser\Grids\ExampleParserGrid;
use Illuminate\Support\Facades\DB;

class ParserRepository
{
    private $parserGrid;

    /**
     * ParserRepository constructor.
     * TODO: Вмемсто ExampleParserGrid - будет механизм рехолвера Сетки (Grid) для выбора нужной
     * @param ExampleParserGrid $parserGrid
     */
    public function __construct(ExampleParserGrid $parserGrid)
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
