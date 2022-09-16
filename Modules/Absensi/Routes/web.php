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



Route::prefix('absensi')->group(function() {

    Route::group(['middleware' => 'auth'], function () {
        Route::prefix('/')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'AbsensiController@index',
                        'as' => 'absensi'
                    ]
                );
                Route::get(
                    '/data',
                    [
                        'uses' => 'AbsensiController@data',
                        'as' => 'absensi.data'
                    ]
                );
                Route::get(
                    '/detail/{id}',
                    [
                        'uses' => 'AbsensiController@show',
                        'as' => 'absensi.show'
                    ]
                );
                Route::get(
                    '/edit/{id}',
                    [
                        'uses' => 'AbsensiController@edit',
                        'as' => 'absensi.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'AbsensiController@update',
                        'as' => 'absensi.update'
                    ]
                );
                Route::get(
                    '/datamahasiswa/{id}',
                    [
                        'uses' => 'AbsensiController@dataMahasiswa',
                        'as' => 'absensi.datamahasiswa'
                    ]
                );
            }
        );

    });
});
