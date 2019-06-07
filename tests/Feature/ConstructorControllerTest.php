<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ConstructorControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     * Конструктор - создание таблицы.
     *
     * @return void
     */
    public function testTableCanBeCreated()
    {
        $data = [
            'table_title' => 'insomnia',
            'columns' => '[{"type":"string", "title":"dream"},{"type":"integer", "title":"hours"}]',
        ];


        $response = $this->call('POST', env('APP_URL').'/api/constructor_create', $data);

        $this->assertEquals($response->getStatusCode(), 200);

        $response->assertStatus(200);
    }

    /**
     * Конструктор - удаление таблицы.
     *
     * @return void
     */
    public function testTableCanBeDropped()
    {
        $data = [
            'table_title' => 'insomnia',
        ];

        $response = $this->call('POST', env('APP_URL').'/api/constructor_drop', $data);

        $response->assertStatus(200);
    }
}
