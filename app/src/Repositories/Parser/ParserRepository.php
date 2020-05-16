<?php

namespace App\src\Repositories\Parser;

use App\src\Services\Parser\Grids\SupportsGrid;
use Illuminate\Support\Facades\DB;

class ParserRepository
{
    /**
     * Save parser data into table
     * @param array $data
     * @param string $tableName
     */
    public function persist(array $data, string $tableName)
    {
        DB::table($tableName)
            ->insert($data);
    }

    /**
     * Update additional info for specific element
     * @param array $data
     * @param string $tableName
     * @param int $elementId
     */
    public function update(array $data, string $tableName, int $elementId)
    {
        DB::table($tableName)
            ->where('element_id', '=', $elementId)
            ->update($data);
    }

}
