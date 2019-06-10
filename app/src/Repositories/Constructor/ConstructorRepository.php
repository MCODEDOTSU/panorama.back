<?php

namespace App\src\Repositories\Constructor;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ConstructorRepository
{
    public function getInfoConcerningTableRequiredFields(string $tableIdentifier): Collection
    {
        return DB::table('information_schema.columns as c')
            ->join('information_schema.tables as t', function($join){
                $join->on('c.table_schema', '=', 't.table_schema')
                    ->on('c.table_name', '=', 't.table_name');
            })
            ->select( 'c.column_name as title', 'c.is_nullable as required')
            ->where('t.table_name', $tableIdentifier)
            ->get();
    }
}
