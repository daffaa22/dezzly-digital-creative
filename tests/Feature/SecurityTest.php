<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_responses_include_baseline_security_headers(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_login_page_does_not_expose_default_credentials(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertDontSee('dezzly123');
    }

    public function test_login_is_rate_limited_after_five_failed_attempts(): void
    {
        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->post('/login', [
                'email' => 'admin@dezzlycreative.com',
                'password' => 'wrong-password',
            ])->assertRedirect();
        }

        $this->post('/login', [
            'email' => 'admin@dezzlycreative.com',
            'password' => 'wrong-password',
        ])->assertTooManyRequests();
    }
}
