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

Route::group(['prefix' => 'exts'], function () {
    Route::resource('news', 'NewsController');
});

//Ajax routes
Route::post('/security/user/assignroles', 'UserController@assignroles');
Route::post('/security/user/assignperms', 'UserController@assignperms');
Route::post('/security/user/permsbyroles', 'UserController@permsbyroles');
Route::post('/security/user/{user_id}/permsbyroles', 'UserController@permsbyroles');
Route::post('/security/user/changepass', 'UserController@changepass');
Route::post('/security/role/assignPerm', 'RoleController@assignPerm');
Route::post('/account/account/changeAccState', 'AccountController@changeAccState');
Route::post('/getgigrfcbypack', 'PackageassignationController@getgigrfcbypack');
Route::post('/getgigrfcbypackacc', 'AppaccountController@getgigrfcbypackacc');
Route::post('/changestateaccount', 'AppaccountController@changeAccountState');
Route::post('/assignapps', 'AppaccountController@assignApps');
Route::post('/quitapps', 'AppaccountController@quitApps');
Route::post('/getclientrfc', 'AccountController@getClientRfc');
Route::post('/getctausers', 'AccountController@getCtaUsers');
Route::post('/unblockuser', 'AccountController@unblockUser');
Route::post('/getctabin', 'AccountController@getCtaBin');
Route::post('/getmunic', 'Controller@getMunic');
Route::post('/getcpdata', 'Controller@getCpData');




