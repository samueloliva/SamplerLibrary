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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', 'UserController@index');

Route::get('/book', 'BookController@index');
Route::post('/book/change', 'BookController@changeStatus');
Route::post('/book/create', 'BookController@create');

Route::get('/user', 'UserController@user')->middleware('auth:api');

Route::post('/register', 'UserController@register');

