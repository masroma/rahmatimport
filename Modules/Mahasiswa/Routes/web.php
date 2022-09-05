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

Route::prefix('mahasiswa')->group(function() {
  
    Route::group(['middleware' => 'auth'], function () {
        Route::prefix('dashboard')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'DashboardController@index',
                        'as' => 'dashboard'
                    ]
                );
            }
        );

        Route::prefix('info')->group(
            function () {
                Route::get(
                    '/{id}',
                    [
                        'uses' => 'DashboardController@detailinfo',
                        'as' => 'info'
                    ]
                );
            }
        );
       
        Route::prefix('informasimatakuliah')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'InformasiMatakuliahController@index',
                        'as' => 'informasimatakuliah'
                    ]
                );
                Route::get(
                    '/show/{id}',
                    [
                        'uses' => 'InformasiMatakuliahController@show',
                        'as' => 'informasimatakuliah.show'
                    ]
                );
                Route::get(
                    '/cetak',
                    [
                        'uses' => 'InformasiMatakuliahController@cetak',
                        'as' => 'informasimatakuliah.cetak'
                    ]
                );
            }
        );

        Route::prefix('karturencanastudy')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'KrsController@data',
                        'as' => 'karturencanastudy.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'KrsController@index',
                        'as' => 'karturencanastudy.index'
                    ]
                );
                Route::get(
                    '/{id}/add',
                    [
                        'uses' => 'KrsController@store',
                        'as' => 'karturencanastudy.add'
                    ]
                );
                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'KrsController@destroy',
                        'as' => 'karturencanastudy.destroy'
                    ]
                );
                Route::get(
                    '/cetak',
                    [
                        'uses' => 'KrsController@cetak',
                        'as' => 'karturencanastudy.cetak'
                    ]
                );
            }
        );

        Route::prefix('kartuhasilstudy')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'KhsController@index',
                        'as' => 'kartuhasilstudy'
                    ]
                );
            }
        );

        Route::prefix('transkipnilai')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'TranskipNilaiController@index',
                        'as' => 'transkipnilai'
                    ]
                );
            }
        );
    });
});
