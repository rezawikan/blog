<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // $user = \App\Models\User::first();
    // $user->name;
    // $userUpdate = $user->fresh();
    // $userUpdate->name = 'Test';
    // $data = [
    //   'fresh' => $userUpdate->name,
    //   'old' => $user->name
    // ];
    // dd($data);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/callback', 'HomeController@callback')->name('callback');

Route::get('/callback', function (Request $request) {
    $http = new \GuzzleHttp\Client;
    // dd()
    $response = $http->post('http://blog.test:8080/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '18',
            'client_secret' => 'zWhHxqS2SU27c81ExotWcqdHrEAJ3tu4OScgdZdX',
            'redirect_uri' => 'http://blog.test:8080/callback',
            'code' => $request->code,
        ],
    ]);



    return json_decode((string) $response->getBody(), true);
});


Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '18',
        'redirect_uri' => 'http://blog.test:8080/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://blog.test:8080/oauth/authorize?'.$query);
});
