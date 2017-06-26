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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Control Services
//Route::get('/service', 'HomeController@index')->name('home');

Route::get('/firstservice', 'ApiserviceController@firstservice')->middleware('auth:api');
Route::get('/getaccstate', 'AppaccountController@getAccState')->middleware('auth:api');

//Test
Route::get('/rolesperms', 'ApiserviceController@getUsersRolesPermsByBd')->middleware('auth:api');

