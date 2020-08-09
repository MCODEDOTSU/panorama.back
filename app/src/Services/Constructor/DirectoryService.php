<?php


namespace App\src\Services\Constructor;


use App\src\Repositories\Constructor\DirectoryRepository;
use App\src\Services\AbstractService;

//class DirectoryService extends AbstractService
class DirectoryService extends AbstractService
{
    public function __construct(DirectoryRepository $directoryRepository)
    {
        $this->repository = $directoryRepository;
    }
}
