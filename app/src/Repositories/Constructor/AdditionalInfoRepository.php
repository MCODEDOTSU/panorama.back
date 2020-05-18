<?php

namespace App\src\Repositories\Constructor;

use Illuminate\Support\Facades\DB;

class AdditionalInfoRepository
{
    public function getAdditionalInfo(string $tableName, int $elementId)
    {
        return DB::table($tableName)
            ->where('element_id', $elementId)
            ->first();
    }

}
