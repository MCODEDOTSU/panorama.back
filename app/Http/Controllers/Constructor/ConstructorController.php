<?php

declare(strict_types=1);

namespace App\Http\Controllers\Constructor;


use App\Http\Controllers\Controller;
use App\src\Services\Constructor\ConstructorService;
use Illuminate\Http\Request;

class ConstructorController extends Controller
{
    private $constructorService;

    /**
     * ConstructorController constructor.
     * @param ConstructorService $constructorService
     */
    public function __construct(ConstructorService $constructorService)
    {
        $this->constructorService = $constructorService;
    }


    /**
     * Создание таблицы
     * @param Request $request :
     * table_title - название таблицы
     * columns - массив столбцов: type, title
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function createTable(Request $request)
    {
        $this->constructorService->createTable($request);

        return response($request->table_title . ' table has been created', 200);
    }


    /**
     * Удаление таблицы
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function dropTable(Request $request)
    {
        $this->constructorService->dropTable($request);

        return response($request->table_title . ' table has been dropped', 200);
    }

    public function updateTable()
    {

    }


}
