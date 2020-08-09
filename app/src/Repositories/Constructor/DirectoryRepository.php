<?php


namespace App\src\Repositories\Constructor;


use App\src\Repositories\AbstractRepository;
use App\src\Models\Directory as DirectoryTable;

class DirectoryRepository extends AbstractRepository
{
    public function __construct(DirectoryTable $directory)
    {
        $this->model = $directory;
    }
}
