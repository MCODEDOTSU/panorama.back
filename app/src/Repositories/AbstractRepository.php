<?php


namespace App\src\Repositories;


abstract class AbstractRepository
{
    public $model;

    public function getAll()
    {
        return $this->model->get();
    }
}
