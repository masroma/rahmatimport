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

Route::prefix('akademik')->group(function() {
    Route::group(['middleware' => 'auth'], function () {
        Route::prefix('kampus')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'KampusController@data',
                        'as' => 'kampus.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'KampusController@index',
                        'as' => 'kampus.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'KampusController@create',
                        'as' => 'kampus.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'KampusController@store',
                        'as' => 'kampus.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'KampusController@edit',
                        'as' => 'kampus.edit'
                    ]
                );

                Route::get(
                    '/{id}/show',
                    [
                        'uses' => 'KampusController@show',
                        'as' => 'kampus.show'
                    ]
                );


                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'KampusController@update',
                        'as' => 'kampus.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'KampusController@destroy',
                        'as' => 'kampus.destroy'
                    ]
                );
            }
        );

        // fakultas
        Route::prefix('fakultas')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'FakultasController@data',
                        'as' => 'fakultas.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'FakultasController@index',
                        'as' => 'fakultas.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'FakultasController@create',
                        'as' => 'fakultas.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'FakultasController@store',
                        'as' => 'fakultas.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'FakultasController@edit',
                        'as' => 'fakultas.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'FakultasController@update',
                        'as' => 'fakultas.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'FakultasController@destroy',
                        'as' => 'fakultas.destroy'
                    ]
                );
            }
        );

        // jurusan
        Route::prefix('jurusan')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'JurusanController@data',
                        'as' => 'jurusan.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'JurusanController@index',
                        'as' => 'jurusan.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'JurusanController@create',
                        'as' => 'jurusan.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'JurusanController@store',
                        'as' => 'jurusan.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'JurusanController@edit',
                        'as' => 'jurusan.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'JurusanController@update',
                        'as' => 'jurusan.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'JurusanController@destroy',
                        'as' => 'jurusan.destroy'
                    ]
                );
            }
        );
    });
});
