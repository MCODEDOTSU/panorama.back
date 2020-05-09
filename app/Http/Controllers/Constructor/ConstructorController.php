<?php

declare(strict_types=1);

namespace App\Http\Controllers\Constructor;

use App\Http\Controllers\Controller;
use App\src\Services\Constructor\ConstructorService;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
     * Получить таблицу для слоя
     * @param $layerId
     * @return ResponseFactory|Response
     */
    public function getToLayer(int $layerId)
    {
        try {
            return response($this->constructorService->getToLayer($layerId), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Создание метаданных
     * @param int $layerId
     * @param Request $request :
     * table_title - название таблицы
     * columns - массив столбцов: type, title
     * @return ResponseFactory|Response
     */
    public function create(int $layerId, Request $request)
    {
        $columns = array_filter($request->columns, function ($value) {
            return !$value['is_deleted'];
        });

        if(empty($columns)) {
            return response('', 200);
        }

        $data = ['data' => $columns];
        $validator = Validator::make($data, [
            'data.*.title' => 'required|string',
            'data.*.tech_title' => 'required'
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        try {
            return response($this->constructorService->create($layerId, $columns), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Обновление метдаданных
     * @param int $layerId
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function update(int $layerId, Request $request)
    {

        $columns = array_filter($request->columns, function ($value) {
            return !($value['is_deleted'] && empty($value['id']));
        });

        $data = ['data' => $columns];

        $validator = Validator::make($data, [
            'data.*.title' => 'required|string',
            'data.*.tech_title' => 'required'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }

        try {
            return response($this->constructorService->update($layerId, $columns), 200);
        } catch (Exception $ex) {
            return response(['error' => $ex->getMessage()], 500);
        }
    }

    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        foreach ($request->columns as $columnData) {
            return $columnData;
        }
    }

    public function getSpecificType(string $type)
    {
        return $this->constructorService->getSpecificType($type);
    }
}
