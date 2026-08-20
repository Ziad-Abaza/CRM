<?php

namespace Tests\Feature;

use Database\Seeders\DefaultCompanySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed(DefaultCompanySeeder::class);
        $response = $this->get('/en');

        $response->assertStatus(200);
    }
}
