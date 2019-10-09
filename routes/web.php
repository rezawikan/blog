<?php
use Illuminate\Http\Request;
use App\Notifications\Comments\CommentCreated;
use App\Models\User;
use App\Models\Comment;
use App\App\Notifications\Models\DatabaseNotification;
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
// Route::get('/notification', function() {
//
//   // $notification = DatabaseNotification::find('97a41cf4-d218-4de0-ad7c-d00c33f546e4');
//
//   // dd($notification);
//   $user = User::find(1);
//   $comment = Comment::find(1);
//   // dd($comment);
//
//   $user->notify(new CommentCreated($comment));
// });
//
// Route::get('/', function () {
//     // $user = \App\Models\User::first();
//     // $user->name;
//     // $userUpdate = $user->fresh();
//     // $userUpdate->name = 'Test';
//     // $data = [
//     //   'fresh' => $userUpdate->name,
//     //   'old' => $user->name
//     // ];
//     // dd($data);
// });
//
// Auth::routes();
//
// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/callback', 'HomeController@callback')->name('callback');
//
// Route::get('/callback', function (Request $request) {
//     $http = new \GuzzleHttp\Client;
//     // dd()
//     $response = $http->post('http://blog.test:8080/oauth/token', [
//         'form_params' => [
//             'grant_type' => 'authorization_code',
//             'client_id' => '18',
//             'client_secret' => 'zWhHxqS2SU27c81ExotWcqdHrEAJ3tu4OScgdZdX',
//             'redirect_uri' => 'http://blog.test:8080/callback',
//             'code' => $request->code,
//         ],
//     ]);
//
//
//
//     return json_decode((string) $response->getBody(), true);
// });
//
//
// Route::get('/redirect', function () {
//     $query = http_build_query([
//         'client_id' => '18',
//         'redirect_uri' => 'http://blog.test:8080/callback',
//         'response_type' => 'code',
//         'scope' => '',
//     ]);
//
//     return redirect('http://blog.test:8080/oauth/authorize?'.$query);
// });
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::resource('permission', 'PermissionController');
});
