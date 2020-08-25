<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use Illuminate\Http\Request;
use Excel;

class ToolController
{

    /**
     * UserController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
    }

    /**
     * Экспорт Данных в Эксель
     * @param Request $request
     * @return
     */
    public function exportExcel(Request $request)
    {
        $export = new InvoicesExport($request->data);
        $filename = date('Ymd-His') . '.xlsx';
        Excel::store($export, "public/export/$filename");
        return [ "public/storage/export/$filename" ];
    }

}
