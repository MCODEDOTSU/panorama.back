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
        Schema::create($request->title, function (Blueprint $table) use ($request) {
            $table->string('field_1');
        });

        return response($request->title.' table has been created', 200);
    }


    public function dropTable(Request $request)
    {
        Schema::dropIfExists($request->title);

        return response($request->title.' table has been dropped', 200);
    }

}
