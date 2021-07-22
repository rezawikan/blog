<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\PrivateUserResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Handle a login request to the application.
     *
     * @param  App\Http\Requests\Auth\LoginRequest $request
     * @return App\Http\Resources\PrivateUserResource
     *
     * @throws 401 with errors
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::once($request->only('email', 'password'))) {
            return response()->json([
              'errors' => [
                'email' => ['Could not login with those det']
                ]
              ], 401);
        }

        return (new PrivateUserResource($request->user()))
                ->additional([
                  'meta' => [
                    'token' => auth()->user()->createToken('Pesrsonal')->plainTextToken
                  ]
                ]);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  App\Http\Requests\Auth\LoginRequest $request
     * @return App\Http\Resources\PrivateUserResource
     *
     * @throws 401 with errors
     */
    public function logout()
    {
        if (isset(auth()->user()->tokens)) {
            auth()->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
        }
    }
}
