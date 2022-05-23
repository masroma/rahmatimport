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

Route::prefix('managementuser')->group(function() {
    // Route::get('/', 'ManagementUserController@index');
    Route::group(['middleware' => 'auth'], function () {
 // user
        Route::prefix('user')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'UserController@data',
                        'as' => 'user.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'UserController@index',
                        'as' => 'user.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'UserController@create',
                        'as' => 'user.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'UserController@store',
                        'as' => 'user.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'UserController@edit',
                        'as' => 'user.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'UserController@update',
                        'as' => 'user.update'
                    ]
                );
                Route::get(
                    '/editprofile',
                    [
                        'uses' => 'UserController@editprofile',
                        'as' => 'user.editprofile'
                    ]
                );
                Route::post(
                    '/updateprofile/{id}',
                    [
                        'uses' => 'UserController@proseseditprofile',
                        'as' => 'user.updateprofile'
                    ]
                );
                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'UserController@destroy',
                        'as' => 'user.destroy'
                    ]
                );
            }
        );
    });
});


