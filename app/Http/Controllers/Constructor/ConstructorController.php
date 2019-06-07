<?php

namespace App\Http\Controllers\Constructor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ConstructorController extends Controller
{

    public function createTable(Request $request)
    {
        Schema::create($request->table_title, function (Blueprint $table) use ($request) {

            $colArr = json_decode($request->columns);

            foreach ($colArr as $col) {
                $typePr = $col->type;
                $table->$typePr(''.$col->title.'');
            }

        });

        return response($request->table_title.' table has been created', 200);
    }


    public function dropTable(Request $request)
    {
        Schema::dropIfExists($request->table_title);

        return response($request->table_title.' table has been dropped', 200);
    }

    public function updateTable()
    {

    }


}
