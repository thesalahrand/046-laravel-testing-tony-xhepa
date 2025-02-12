<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertSee('Laracasts');
        $response->assertSeeInOrder(['Laracasts', 'Laravel News']);

        $response->assertStatus(200);
    }

    public function test_the_about_returns_a_successful_response(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
    }
}
