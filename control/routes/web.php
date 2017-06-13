<?php

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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('account', 'AccountController');

Route::group(['prefix' => 'config'], function () {
    Route::resource('package', 'PackageController');
});

Route::group(['prefix' => 'directory'], function () {
    Route::resource('client', 'ClientController');
    Route::resource('distributor', 'DistributorController');
});

Route::group(['prefix' => 'security'], function () {
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
});


Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://advans.control.mx/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://advans.control.mx/oauth/authorize?'.$query);
});


Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://advans.control.mx/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://advans.control.mx/oauth/authorize?'.$query);
});


Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://advans.control.mx/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '3',
            'client_secret' => 'WCnCTZ7gyWObzN4DgGyP6pVB2YO18QYIMnMPLP6o',
            'redirect_uri' => 'http://advans.control.mx/callback',
            'code' => $request->code,
        ],
    ]);

    $auth = json_decode($response->getBody());
    
    $response = $http->get('http://advans.control.mx/api/user', [
        'headers' => [
            'Authorization' => 'Bearer '.$auth->access_token,
        ]
    ]);

    $todos = json_decode( (string) $response->getBody() );

    dd($todos);
    
    $todoList = "";
    foreach ($todos as $todo) {
        $todoList .= "<li>{$todo->task}".($todo->done ? '✅' : '')."</li>";
    }

    echo "<ul>{$todoList}</ul>";

});


//Ajax routes
Route::post('/security/user/permsbyroles', 'UserController@permsbyroles');
Route::post('/security/user/{user_id}/permsbyroles', 'UserController@permsbyroles');




