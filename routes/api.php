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

Route::group([
    'namespace' => 'Api',
    'prefix' => 'v1'
], function ($router) {
    Route::post('login', 'AuthController@auth');
    
    Route::post('user/recovery', 'UserRecoveryController@recovery');
    Route::get('user/recovery/{token}', 'UserRecoveryController@recoveryForm')->name('user.password.recoveryUser.form');
    Route::post('user/recovery/{token}', 'UserRecoveryController@changePassword');

    Route::group([
        'middleware' => ['api','jwt.auth']
    ], function ($router) {
        /*
        |--------------------------------------------------------------------------
        | Routes about Authentication
        |--------------------------------------------------------------------------
        */
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');

        /*
        |--------------------------------------------------------------------------
        | Routes about users
        |--------------------------------------------------------------------------
        */
        Route::post('users/image/update/{id}', 'UserController@updateImage');
        Route::resource('users', 'UserController');
        /*
        |--------------------------------------------------------------------------
        | UserRecovery Routes
        |--------------------------------------------------------------------------
        */
        Route::resource('user-recoveries', 'UserRecoveryController');
    
        /*
        |--------------------------------------------------------------------------
        | Task Routes
        |--------------------------------------------------------------------------
        */
        Route::resource('tasks', 'TaskController');
    });
});
