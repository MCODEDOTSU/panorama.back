<?php


namespace App\src\Services;


abstract class AbstractService
{
    protected $repository;

    public function getAll()
    {
        return $this->repository->getAll();
    }
}
