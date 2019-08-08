<?php

namespace App\src\Services\Constructor\Entities;


use Exception;
use Illuminate\Container\Container;

class FieldsResolver
{
    private $container;
    private $path = 'App\src\Services\Constructor\Entities\\';

    /**
     * FieldsResolver constructor.
     * @param $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    public function selectFieldType(array $columnInfo)
    {
        $class = $this->path . $this->snakeToCamel($columnInfo['type']);

        if (class_exists($class)) {
            /** @var AbstractField $readyBakedClass */
            $readyBakedClass = $this->container->make($class);
            $readyBakedClass->setTitle($columnInfo['title']);
            if (isset($columnInfo['new_tech_title'])) {
                $readyBakedClass->setNewTechTitle($columnInfo['new_tech_title']);
            }
            $readyBakedClass->setTechTitle($columnInfo['tech_title']);
            $readyBakedClass->setRequired($columnInfo['required']);

            return $readyBakedClass;
        }

        return new Exception('There is no such field type. Add which is necessary');
    }

    /**
     * @param $str
     * @return string
     */
    private function snakeToCamel($str): string
    {
        return ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
    }
}
