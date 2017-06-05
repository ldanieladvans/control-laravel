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
    Route::post('/csearch', 'ClientController@clientsearch')->name('client.csearch');
});



