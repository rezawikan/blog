<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_register_someone()
    {
        $res = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', 'api/auth/register', [
          'name' => 'Mochammad',
          'email' => 'reza.wikan.dito@gmail.com',
          'password' => 'password',
          'password_confirmation' => 'password'
        ])->assertStatus(201);
    }
}
