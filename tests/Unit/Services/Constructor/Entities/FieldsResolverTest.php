<?php

namespace Tests\Unit\Services\Constructor\Entities;


use App\src\Services\Constructor\Entities\FieldsResolver;
use App\src\Services\Constructor\Entities\TextField;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class FieldsResolverTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function testIfFieldCanBeSelected()
    {
        $fieldsResolver = new FieldsResolver(new Container());

        $columnInfo = [
            'type' => 'text_field',
            'title' => 'abstraction_one'
        ];

        $instantiatedFieldClass = $fieldsResolver->selectFieldType($columnInfo);

        $this->assertInstanceOf(TextField::class, $instantiatedFieldClass);

    }

    public function testIfExceptionIsThrownWhenImproperFieldIsChosen()
    {
        $fieldsResolver = new FieldsResolver(new Container());

        $columnInfo = [
            'type' => 'some_field',
            'title' => 'abstraction_one'
        ];

        $instantiatedFieldClass = $fieldsResolver->selectFieldType($columnInfo);

        $this->assertInstanceOf(Exception::class, $instantiatedFieldClass);
    }
}
