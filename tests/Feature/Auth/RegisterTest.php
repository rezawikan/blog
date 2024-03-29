<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_register_user()
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

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_register_with_wrong_email()
    {
        $res = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', 'api/auth/register', [
          'name' => 'Mochammad',
          'email' => 'reza.wikan',
          'password' => 'password',
          'password_confirmation' => 'password'
        ])->assertStatus(422);
    }
}
