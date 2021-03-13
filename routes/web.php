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


/*Route::get('/', function () {
    return view('users/index');
});*/

//Route::resource('/', 'UserController');


Route::resource('/','UserController');

Route::get('/{id}/edit','UserController@edit');

Route::get('/{id}/ciudad','UserController@ciudad');

Route::delete('/{id}', 'UserController@destroy')->name('user.destroy');