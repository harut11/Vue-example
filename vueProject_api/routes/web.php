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

//Route::get('/getCsrfToken', function (){
//   return response()->json(['token' => csrf_token()], 200);
//});
//
//Route::get('/posts', 'PostController@index');

//Route::get('/verify', 'PostController@verify');
//
//Route::post('/', 'PostController@store')->name('store');
