<?php


namespace App\src\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    public $model;

    public function getAll()
    {
        return $this->model->get();
    }

    public function create($data): Model
    {
        return $this->model->create($data);
    }
}
