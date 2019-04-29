<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::post('login', 'API\UserController@login');

Route::prefix('auth')->group(function () {
    Route::post('register', 'API\Auth\RegisterController@register');
    Route::post('login', 'API\Auth\LoginController@login');
    Route::post('logout', 'API\Auth\LoginController@logout');
    Route::post('reset/password/request', 'API\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('reset/password/send', 'API\Auth\ResetPasswordController@reset');
});

Route::resource('users','API\User\UserController')->middleware('auth:api');
Route::resource('posts','API\Post\PostController')->middleware('auth:api');
Route::put('posts-restore/{post}', 'API\Post\PostController@restore')->name('posts.restore')->middleware('auth:api');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->get('/token', function (Request $request) {
//     // return auth()->user()->tokens->last()->id;
//     auth()->user()->tokens->each(function ($token, $key){
//       dd($token->id);
//     });
// });
