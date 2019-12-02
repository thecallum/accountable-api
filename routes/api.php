<?php

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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});


Route::group(['prefix' => 'tasks', 'middleware' => [
    'auth'
]], function ($router) {
    Route::get('/', 'TaskController@index');
});


Route::any('*', function() {
    return response()->json(['message' => 'Path does not exist'], 401);
});


// Route::get('/', function () {
//     $msg = ["message" => 'success' ];
    
//     return $msg;
// })->middleware('auth');