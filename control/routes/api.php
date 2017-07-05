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

Route::get('/getaccstate', 'ApiserviceController@getAccState')->middleware('auth:api');
Route::get('/getnews', 'ApiserviceController@getNews')->middleware('auth:api');


//Test
Route::get('/rolesperms', 'ApiserviceController@getUsersRolesPermsByBd')->middleware('auth:api');

