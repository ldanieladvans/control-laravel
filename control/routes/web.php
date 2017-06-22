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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'account'], function () {
    Route::resource('account', 'AccountController');
    Route::resource('asigpaq', 'PackageassignationController');
    Route::resource('appcta', 'AppaccountController');
});

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
    Route::resource('binnacle', 'BinnacleController');
});


Route::get('/redirect', function () {
    $http = new GuzzleHttp\Client;
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://advans.control.mx/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://advans.control.mx/oauth/authorize?'.$query);

});



Route::get('/getaccesstoken', function () {
    $http = new GuzzleHttp\Client;
    $response = $http->post('http://advans.control.mx/oauth/token', [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => '5',
        'client_secret' => 'zYJPeZrqWbW1lAHl80b4Zn0fFYi2iZN6Unlgcdu6',
        'username' => 'chino270786@gmail.com',
        'password' => 'Daniel123',
        'scope' => '*',
    ],
]);
    echo "<pre>";
    print_r(base64_decode('RGFuaWVsMTIz'));die();
    echo "</pre>";

return json_decode((string) $response->getBody(), true);

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
    
    $response = $http->get('http://advans.control.mx/api/firstservice', [
        'headers' => [
            'Authorization' => 'Bearer '.$auth->access_token,
        ]
    ]);

    return $response;
    echo "<pre>";
    print_r($auth);die();
    echo "</pre>";

    $todos = json_decode( (string) $response->getBody() );

    dd($todos);
    
    $todoList = "";
    foreach ($todos as $todo) {
        $todoList .= "<li>{$todo->task}".($todo->done ? '✅' : '')."</li>";
    }

    echo "<ul>{$todoList}</ul>";

});


Route::get('/getcuentaaccesstoken', function () {
    $http = new GuzzleHttp\Client();
    $response = $http->post('http://advans.cuenta.mx/oauth/token', [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => '4',
        'client_secret' => 'SAFwNTuBOV9AdyJtLJtiWXc0yHB5I2L0MKGdWvNe',
        'username' => 'mabel@gmail.com',
        'password' => base64_decode('RGFuaWVsMTIz'),
        'scope' => '*',
    ],
]);
    $vartemp = json_decode((string) $response->getBody(), true);


   $responseotro = $http->get('http://advans.cuenta.mx/api/createbd', [
        'headers' => [
            'Authorization' => 'Bearer '.$vartemp['access_token'],
        ]
    ]);
    

   
return json_decode((string) $responseotro->getBody(), true);

});


//Ajax routes
Route::post('/security/user/assignroles', 'UserController@assignroles');
Route::post('/security/user/assignperms', 'UserController@assignperms');
Route::post('/security/user/permsbyroles', 'UserController@permsbyroles');
Route::post('/security/user/{user_id}/permsbyroles', 'UserController@permsbyroles');
Route::post('/security/user/changepass', 'UserController@changepass');
Route::post('/security/role/assignPerm', 'RoleController@assignPerm');
Route::post('/account/account/changeAccState', 'AccountController@changeAccState');
Route::post('/getgigrfcbypack', 'AppaccountController@getgigrfcbypack');
Route::post('/changestateaccount', 'AppaccountController@changeAccountState');
Route::post('/assignapps', 'AppaccountController@assignApps');




