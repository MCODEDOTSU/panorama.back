<?php


namespace App\src\Services\Constructor\Entities;


interface FieldInterface
{
    /**
     * Если новое поле - не нулевое, то необходимо проставить дефолтное значение
     * @return mixed
     */
    public function setDefaultValue();
    
    /**
     * @return string
     * Тип соответствует типу в объектной модели Schema
     */
    public function getType(): string;
}
