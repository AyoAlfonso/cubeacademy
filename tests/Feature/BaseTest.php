<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BaseTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/api');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Welcome to the Cubeacademy API',
            ])
            ->assertHeader('Content-Type', 'application/json');
    }

}
