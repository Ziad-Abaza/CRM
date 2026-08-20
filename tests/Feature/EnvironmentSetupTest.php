<?php

namespace Tests\Feature;

use Database\Seeders\DefaultCompanySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EnvironmentSetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_boots_and_returns_successful_response(): void
    {
        $this->seed(DefaultCompanySeeder::class);
        $response = $this->get('/en');
        $response->assertStatus(200);
    }

    public function test_database_connection_is_operational(): void
    {
        $result = DB::select('SELECT 1 as result');
        $this->assertNotEmpty($result);
        $this->assertEquals(1, $result[0]->result);
    }
}

