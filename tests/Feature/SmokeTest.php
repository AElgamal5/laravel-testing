<?php

namespace Tests\Feature;

use Tests\TestCase;

class SmokeTest extends TestCase
{
    /**
     * A simple smoke test to ensure all pages are loaded successfully.
     */

    public function test_home_page_loads_successfully()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_login_page_loads_successfully()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_signup_page_loads_successfully()
    {
        $response = $this->get('/signup');

        $response->assertStatus(200);
    }
}
