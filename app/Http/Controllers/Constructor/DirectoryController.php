<?php


namespace App\Http\Controllers\Constructor;

use App\Http\Controllers\Controller;
use App\src\Services\Constructor\DirectoryService;

/**
 * Для ссылок на справочники
 * Class DirectoryController
 * @package App\Http\Controllers\Constructor
 */
class DirectoryController extends Controller
{
    /**
     * DirectoryController constructor.
     * @param DirectoryService $directoryService
     */
    public function __construct(DirectoryService $directoryService)
    {
        $this->service = $directoryService;
    }

    /**
     * @param $entityName
     * entityName => Наименование связанной таблицы
     * @return
     */
    public function getEntities($entityName)
    {
        return $this->service->getEntities($entityName);
    }
}
