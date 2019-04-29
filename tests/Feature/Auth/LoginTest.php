<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Passport\Passport;

class LoginTest extends TestCase
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
    public function test_it_requires_an_email()
    {
        $this->json('POST', 'api/auth/login')
        ->assertJsonValidationErrors(['email']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_requires_a_password()
    {
        $this->json('POST', 'api/auth/login')
        ->assertJsonValidationErrors(['password']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_an_error_if_credentials_dont_match()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/login', [
        'email' => $user->email,
        'password' => 'nope'
      ])->assertJsonValidationErrors(['email']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_return_true()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_returns_a_validation_error_if_credentials_dont_matchs()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ])->assertJsonFragment([
          'email' => $user->email,
          'name' => $user->name
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_to_login_and_then_access_me()
    {
        $user = factory(User::class)->create();

        $token = $this->json('POST', 'api/auth/login', [
          'email' => $user->email,
          'password' => 'password'
        ]);

        $token = json_decode($token->getContent());

        $response = $this->withHeaders([
          'Accept' => 'application/json',
          'Authorization' => 'Bearer '.$token->meta->token,
        ])->get('api/user');

        $response->assertOk();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_to_login_and_thenlogout()
    {
        $user = factory(User::class)->create();

        $token = $this->json('POST', 'api/auth/login', [
        'email' => $user->email,
        'password' => 'password'
      ]);

        $token = json_decode($token->getContent());

        $response = $this->withHeaders([
        'Accept' => 'application/json',
        'Authorization' => 'Bearer '.$token->meta->token,
      ])->post('api/auth/logout');

        $response->assertOk();
    }
}
