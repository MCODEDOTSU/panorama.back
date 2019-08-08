<?php

declare(strict_types=1);

namespace App\Http\Controllers\Constructor;


use App\Http\Controllers\Controller;
use App\src\Services\Constructor\ConstructorService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return ResponseFactory|Response
     */
    public function createTable(Request $request)
    {
        $newTableName = $this->constructorService->createTable($request);

        return response($newTableName . ' table has been created', 200);
    }


    /**
     * Удаление таблицы
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function dropTable(Request $request)
    {
        $this->constructorService->dropTable($request);

        return response($request->table_title . ' table has been dropped', 200);
    }

    /**
     * Получить информацию о полях таблицы: наименование, тип, required
     * @param string $tableIdentifier
     * @return array
     */
    public function getTableInfo(string $tableIdentifier)
    {
        return response($this->constructorService->getTableInfo($tableIdentifier), 200);
    }

    /**
     * Проверить, существует ли таблица
     * @param string $tableIdentifier
     * @return ResponseFactory|Response
     */
    public function isTableExists(string $tableIdentifier)
    {
        return response($this->constructorService->isTableExists($tableIdentifier), 200);
    }

    public function getSpecificType(string $type)
    {
        return $this->constructorService->getSpecificType($type);
    }

    /**
     * Обновление данных (некоторые данные могут быть удаены в связи с удалением определенных столбцов)
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function updateTable(Request $request)
    {
        $newTableName = $this->constructorService->updateTable($request);

        return response($newTableName . ' table has been updated', 200);
    }
}
