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

// Route::get('/login', 'UserController@login');

// Route::get('/person', function () {
//     $person = [
//         'first_name' => 'Sean',
//         'last_name' => 'Pooley',
//     ];

//     return $person;
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');


});

Route::get('/', function () {
    $msg = [
        "message" => 'success'
    ];
    
    return $msg;
})->middleware('auth');

Route::get('/login', [ 'as' => 'login', 'uses' => 'AuthController@login']);

Route::post('/auth/register', 'AuthController@register');
