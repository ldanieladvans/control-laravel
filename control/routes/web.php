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

    $client = new \GuzzleHttp\Client();


    $r = $client->post('http://wp.dev/index.php/wp-json/wp/v2/posts', 
        ['json' => [
            "access_token" =>csrf_token(),
            "another_payload" => 'www'
        ]]);
    dd($r);

	echo json_decode((string) $r->getBody(), true);
});


//Ajax routes
Route::post('/security/user/permsbyroles', 'UserController@permsbyroles');
Route::post('/security/user/{user_id}/permsbyroles', 'UserController@permsbyroles');




