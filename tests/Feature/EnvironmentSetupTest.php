<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EnvironmentSetupTest extends TestCase
{
    public function test_application_boots_and_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_database_connection_is_operational(): void
    {
        $result = DB::select('SELECT 1 as result');
        $this->assertNotEmpty($result);
        $this->assertEquals(1, $result[0]->result);
    }
}

