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

          //role
        Route::prefix('role')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'RoleController@data',
                        'as' => 'role.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'RoleController@index',
                        'as' => 'role.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'RoleController@create',
                        'as' => 'role.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'RoleController@store',
                        'as' => 'role.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'RoleController@edit',
                        'as' => 'role.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'RoleController@update',
                        'as' => 'role.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'RoleController@destroy',
                        'as' => 'role.destroy'
                    ]
                );
            }
        );

        // permission
        Route::prefix('permission')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'PermissionController@data',
                        'as' => 'permission.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'PermissionController@index',
                        'as' => 'permission.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'PermissionController@create',
                        'as' => 'permission.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'PermissionController@store',
                        'as' => 'permission.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'PermissionController@edit',
                        'as' => 'permission.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'PermissionController@update',
                        'as' => 'permission.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'PermissionController@destroy',
                        'as' => 'permission.destroy'
                    ]
                );
            }
        );

        // menu
Route::prefix('menu')->group(
    function () {
        Route::get(
            '/data',
            [
                'uses' => 'MenuController@data',
                'as' => 'menu.data'
            ]
        );
        Route::get(
            '/',
            [
                'uses' => 'MenuController@index',
                'as' => 'menu.index'
            ]
        );
        Route::get(
            '/create',
            [
                'uses' => 'MenuController@create',
                'as' => 'menu.create'
            ]
        );
        Route::post(
            '/store',
            [
                'uses' => 'MenuController@store',
                'as' => 'menu.store'
            ]
        );
        Route::get(
            '/{id}/edit',
            [
                'uses' => 'MenuController@edit',
                'as' => 'menu.edit'
            ]
        );
        Route::post(
            '/update/{id}',
            [
                'uses' => 'MenuController@update',
                'as' => 'menu.update'
            ]
        );


        Route::get(
            '/{id}/delete',
            [
                'uses' => 'MenuController@destroy',
                'as' => 'menu.destroy'
            ]
        );
    }
);


    });
});


