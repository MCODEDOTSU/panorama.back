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
     * A basic test example.
     *
     * @return void
     */
    public function testTableCanBeCreated()
    {
        $response = $this->post('/api/constructor_create');

        $response->assertStatus(200);
    }
}
