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


    public function selectFieldType(string $fieldType): AbstractField
    {
        $class = $this->path . $this->snakeToCamel($fieldType);

        if (class_exists($class)) {
            return $this->container->make($class);
        }

        return new Exception('There is no such field type. Add which is necessary');
    }

    /**
     * @param $str
     * @return string
     */
    private function snakeToCamel($str)
    {
        return ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
    }
}
