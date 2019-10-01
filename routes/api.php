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

Route::namespace('Api')->group(function () {
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', 'UserController@me');

        Route::get('/todos', 'TodoController@index');
        Route::post('/todos', 'TodoController@store');

        Route::get('/todo/{todo}', 'TodoController@show')->middleware('can:view,todo');
        Route::put('/todo/{todo}', 'TodoController@update')->middleware('can:update,todo');
        Route::delete('/todo/{todo}', 'TodoController@destroy')->middleware('can:delete,todo');
    });
});
